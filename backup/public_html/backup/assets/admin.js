(function () {
  'use strict';

  // packages/alpinejs/src/scheduler.js
  var flushPending = false;
  var flushing = false;
  var queue = [];
  var lastFlushedIndex = -1;
  function scheduler(callback) {
    queueJob(callback);
  }
  function queueJob(job) {
    if (!queue.includes(job)) queue.push(job);
    queueFlush();
  }
  function dequeueJob(job) {
    let index = queue.indexOf(job);
    if (index !== -1 && index > lastFlushedIndex) queue.splice(index, 1);
  }
  function queueFlush() {
    if (!flushing && !flushPending) {
      flushPending = true;
      queueMicrotask(flushJobs);
    }
  }
  function flushJobs() {
    flushPending = false;
    flushing = true;
    for (let i = 0; i < queue.length; i++) {
      queue[i]();
      lastFlushedIndex = i;
    }
    queue.length = 0;
    lastFlushedIndex = -1;
    flushing = false;
  }

  // packages/alpinejs/src/reactivity.js
  var reactive;
  var effect;
  var release;
  var raw;
  var shouldSchedule = true;
  function disableEffectScheduling(callback) {
    shouldSchedule = false;
    callback();
    shouldSchedule = true;
  }
  function setReactivityEngine(engine) {
    reactive = engine.reactive;
    release = engine.release;
    effect = callback => engine.effect(callback, {
      scheduler: task => {
        if (shouldSchedule) {
          scheduler(task);
        } else {
          task();
        }
      }
    });
    raw = engine.raw;
  }
  function overrideEffect(override) {
    effect = override;
  }
  function elementBoundEffect(el) {
    let cleanup2 = () => {};
    let wrappedEffect = callback => {
      let effectReference = effect(callback);
      if (!el._x_effects) {
        el._x_effects = new Set();
        el._x_runEffects = () => {
          el._x_effects.forEach(i => i());
        };
      }
      el._x_effects.add(effectReference);
      cleanup2 = () => {
        if (effectReference === void 0) return;
        el._x_effects.delete(effectReference);
        release(effectReference);
      };
      return effectReference;
    };
    return [wrappedEffect, () => {
      cleanup2();
    }];
  }

  // packages/alpinejs/src/mutation.js
  var onAttributeAddeds = [];
  var onElRemoveds = [];
  var onElAddeds = [];
  function onElAdded(callback) {
    onElAddeds.push(callback);
  }
  function onElRemoved(el, callback) {
    if (typeof callback === "function") {
      if (!el._x_cleanups) el._x_cleanups = [];
      el._x_cleanups.push(callback);
    } else {
      callback = el;
      onElRemoveds.push(callback);
    }
  }
  function onAttributesAdded(callback) {
    onAttributeAddeds.push(callback);
  }
  function onAttributeRemoved(el, name, callback) {
    if (!el._x_attributeCleanups) el._x_attributeCleanups = {};
    if (!el._x_attributeCleanups[name]) el._x_attributeCleanups[name] = [];
    el._x_attributeCleanups[name].push(callback);
  }
  function cleanupAttributes(el, names) {
    if (!el._x_attributeCleanups) return;
    Object.entries(el._x_attributeCleanups).forEach(([name, value]) => {
      if (names === void 0 || names.includes(name)) {
        value.forEach(i => i());
        delete el._x_attributeCleanups[name];
      }
    });
  }
  var observer = new MutationObserver(onMutate);
  var currentlyObserving = false;
  function startObservingMutations() {
    observer.observe(document, {
      subtree: true,
      childList: true,
      attributes: true,
      attributeOldValue: true
    });
    currentlyObserving = true;
  }
  function stopObservingMutations() {
    flushObserver();
    observer.disconnect();
    currentlyObserving = false;
  }
  var recordQueue = [];
  var willProcessRecordQueue = false;
  function flushObserver() {
    recordQueue = recordQueue.concat(observer.takeRecords());
    if (recordQueue.length && !willProcessRecordQueue) {
      willProcessRecordQueue = true;
      queueMicrotask(() => {
        processRecordQueue();
        willProcessRecordQueue = false;
      });
    }
  }
  function processRecordQueue() {
    onMutate(recordQueue);
    recordQueue.length = 0;
  }
  function mutateDom(callback) {
    if (!currentlyObserving) return callback();
    stopObservingMutations();
    let result = callback();
    startObservingMutations();
    return result;
  }
  var isCollecting = false;
  var deferredMutations = [];
  function deferMutations() {
    isCollecting = true;
  }
  function flushAndStopDeferringMutations() {
    isCollecting = false;
    onMutate(deferredMutations);
    deferredMutations = [];
  }
  function onMutate(mutations) {
    if (isCollecting) {
      deferredMutations = deferredMutations.concat(mutations);
      return;
    }
    let addedNodes = [];
    let removedNodes = [];
    let addedAttributes = new Map();
    let removedAttributes = new Map();
    for (let i = 0; i < mutations.length; i++) {
      if (mutations[i].target._x_ignoreMutationObserver) continue;
      if (mutations[i].type === "childList") {
        mutations[i].addedNodes.forEach(node => node.nodeType === 1 && addedNodes.push(node));
        mutations[i].removedNodes.forEach(node => node.nodeType === 1 && removedNodes.push(node));
      }
      if (mutations[i].type === "attributes") {
        let el = mutations[i].target;
        let name = mutations[i].attributeName;
        let oldValue = mutations[i].oldValue;
        let add2 = () => {
          if (!addedAttributes.has(el)) addedAttributes.set(el, []);
          addedAttributes.get(el).push({
            name,
            value: el.getAttribute(name)
          });
        };
        let remove = () => {
          if (!removedAttributes.has(el)) removedAttributes.set(el, []);
          removedAttributes.get(el).push(name);
        };
        if (el.hasAttribute(name) && oldValue === null) {
          add2();
        } else if (el.hasAttribute(name)) {
          remove();
          add2();
        } else {
          remove();
        }
      }
    }
    removedAttributes.forEach((attrs, el) => {
      cleanupAttributes(el, attrs);
    });
    addedAttributes.forEach((attrs, el) => {
      onAttributeAddeds.forEach(i => i(el, attrs));
    });
    for (let node of removedNodes) {
      if (addedNodes.includes(node)) continue;
      onElRemoveds.forEach(i => i(node));
      if (node._x_cleanups) {
        while (node._x_cleanups.length) node._x_cleanups.pop()();
      }
    }
    addedNodes.forEach(node => {
      node._x_ignoreSelf = true;
      node._x_ignore = true;
    });
    for (let node of addedNodes) {
      if (removedNodes.includes(node)) continue;
      if (!node.isConnected) continue;
      delete node._x_ignoreSelf;
      delete node._x_ignore;
      onElAddeds.forEach(i => i(node));
      node._x_ignore = true;
      node._x_ignoreSelf = true;
    }
    addedNodes.forEach(node => {
      delete node._x_ignoreSelf;
      delete node._x_ignore;
    });
    addedNodes = null;
    removedNodes = null;
    addedAttributes = null;
    removedAttributes = null;
  }

  // packages/alpinejs/src/scope.js
  function scope(node) {
    return mergeProxies(closestDataStack(node));
  }
  function addScopeToNode(node, data2, referenceNode) {
    node._x_dataStack = [data2, ...closestDataStack(referenceNode || node)];
    return () => {
      node._x_dataStack = node._x_dataStack.filter(i => i !== data2);
    };
  }
  function closestDataStack(node) {
    if (node._x_dataStack) return node._x_dataStack;
    if (typeof ShadowRoot === "function" && node instanceof ShadowRoot) {
      return closestDataStack(node.host);
    }
    if (!node.parentNode) {
      return [];
    }
    return closestDataStack(node.parentNode);
  }
  function mergeProxies(objects) {
    let thisProxy = new Proxy({}, {
      ownKeys: () => {
        return Array.from(new Set(objects.flatMap(i => Object.keys(i))));
      },
      has: (target, name) => {
        return objects.some(obj => obj.hasOwnProperty(name));
      },
      get: (target, name) => {
        return (objects.find(obj => {
          if (obj.hasOwnProperty(name)) {
            let descriptor = Object.getOwnPropertyDescriptor(obj, name);
            if (descriptor.get && descriptor.get._x_alreadyBound || descriptor.set && descriptor.set._x_alreadyBound) {
              return true;
            }
            if ((descriptor.get || descriptor.set) && descriptor.enumerable) {
              let getter = descriptor.get;
              let setter = descriptor.set;
              let property = descriptor;
              getter = getter && getter.bind(thisProxy);
              setter = setter && setter.bind(thisProxy);
              if (getter) getter._x_alreadyBound = true;
              if (setter) setter._x_alreadyBound = true;
              Object.defineProperty(obj, name, {
                ...property,
                get: getter,
                set: setter
              });
            }
            return true;
          }
          return false;
        }) || {})[name];
      },
      set: (target, name, value) => {
        let closestObjectWithKey = objects.find(obj => obj.hasOwnProperty(name));
        if (closestObjectWithKey) {
          closestObjectWithKey[name] = value;
        } else {
          objects[objects.length - 1][name] = value;
        }
        return true;
      }
    });
    return thisProxy;
  }

  // packages/alpinejs/src/interceptor.js
  function initInterceptors(data2) {
    let isObject2 = val => typeof val === "object" && !Array.isArray(val) && val !== null;
    let recurse = (obj, basePath = "") => {
      Object.entries(Object.getOwnPropertyDescriptors(obj)).forEach(([key, {
        value,
        enumerable
      }]) => {
        if (enumerable === false || value === void 0) return;
        let path = basePath === "" ? key : `${basePath}.${key}`;
        if (typeof value === "object" && value !== null && value._x_interceptor) {
          obj[key] = value.initialize(data2, path, key);
        } else {
          if (isObject2(value) && value !== obj && !(value instanceof Element)) {
            recurse(value, path);
          }
        }
      });
    };
    return recurse(data2);
  }
  function interceptor(callback, mutateObj = () => {}) {
    let obj = {
      initialValue: void 0,
      _x_interceptor: true,
      initialize(data2, path, key) {
        return callback(this.initialValue, () => get(data2, path), value => set(data2, path, value), path, key);
      }
    };
    mutateObj(obj);
    return initialValue => {
      if (typeof initialValue === "object" && initialValue !== null && initialValue._x_interceptor) {
        let initialize = obj.initialize.bind(obj);
        obj.initialize = (data2, path, key) => {
          let innerValue = initialValue.initialize(data2, path, key);
          obj.initialValue = innerValue;
          return initialize(data2, path, key);
        };
      } else {
        obj.initialValue = initialValue;
      }
      return obj;
    };
  }
  function get(obj, path) {
    return path.split(".").reduce((carry, segment) => carry[segment], obj);
  }
  function set(obj, path, value) {
    if (typeof path === "string") path = path.split(".");
    if (path.length === 1) obj[path[0]] = value;else if (path.length === 0) throw error;else {
      if (obj[path[0]]) return set(obj[path[0]], path.slice(1), value);else {
        obj[path[0]] = {};
        return set(obj[path[0]], path.slice(1), value);
      }
    }
  }

  // packages/alpinejs/src/magics.js
  var magics = {};
  function magic(name, callback) {
    magics[name] = callback;
  }
  function injectMagics(obj, el) {
    Object.entries(magics).forEach(([name, callback]) => {
      let memoizedUtilities = null;
      function getUtilities() {
        if (memoizedUtilities) {
          return memoizedUtilities;
        } else {
          let [utilities, cleanup2] = getElementBoundUtilities(el);
          memoizedUtilities = {
            interceptor,
            ...utilities
          };
          onElRemoved(el, cleanup2);
          return memoizedUtilities;
        }
      }
      Object.defineProperty(obj, `$${name}`, {
        get() {
          return callback(el, getUtilities());
        },
        enumerable: false
      });
    });
    return obj;
  }

  // packages/alpinejs/src/utils/error.js
  function tryCatch(el, expression, callback, ...args) {
    try {
      return callback(...args);
    } catch (e) {
      handleError(e, el, expression);
    }
  }
  function handleError(error2, el, expression = void 0) {
    Object.assign(error2, {
      el,
      expression
    });
    console.warn(`Alpine Expression Error: ${error2.message}

${expression ? 'Expression: "' + expression + '"\n\n' : ""}`, el);
    setTimeout(() => {
      throw error2;
    }, 0);
  }

  // packages/alpinejs/src/evaluator.js
  var shouldAutoEvaluateFunctions = true;
  function dontAutoEvaluateFunctions(callback) {
    let cache = shouldAutoEvaluateFunctions;
    shouldAutoEvaluateFunctions = false;
    let result = callback();
    shouldAutoEvaluateFunctions = cache;
    return result;
  }
  function evaluate(el, expression, extras = {}) {
    let result;
    evaluateLater(el, expression)(value => result = value, extras);
    return result;
  }
  function evaluateLater(...args) {
    return theEvaluatorFunction(...args);
  }
  var theEvaluatorFunction = normalEvaluator;
  function setEvaluator(newEvaluator) {
    theEvaluatorFunction = newEvaluator;
  }
  function normalEvaluator(el, expression) {
    let overriddenMagics = {};
    injectMagics(overriddenMagics, el);
    let dataStack = [overriddenMagics, ...closestDataStack(el)];
    let evaluator = typeof expression === "function" ? generateEvaluatorFromFunction(dataStack, expression) : generateEvaluatorFromString(dataStack, expression, el);
    return tryCatch.bind(null, el, expression, evaluator);
  }
  function generateEvaluatorFromFunction(dataStack, func) {
    return (receiver = () => {}, {
      scope: scope2 = {},
      params = []
    } = {}) => {
      let result = func.apply(mergeProxies([scope2, ...dataStack]), params);
      runIfTypeOfFunction(receiver, result);
    };
  }
  var evaluatorMemo = {};
  function generateFunctionFromString(expression, el) {
    if (evaluatorMemo[expression]) {
      return evaluatorMemo[expression];
    }
    let AsyncFunction = Object.getPrototypeOf(async function () {}).constructor;
    let rightSideSafeExpression = /^[\n\s]*if.*\(.*\)/.test(expression) || /^(let|const)\s/.test(expression) ? `(async()=>{ ${expression} })()` : expression;
    const safeAsyncFunction = () => {
      try {
        return new AsyncFunction(["__self", "scope"], `with (scope) { __self.result = ${rightSideSafeExpression} }; __self.finished = true; return __self.result;`);
      } catch (error2) {
        handleError(error2, el, expression);
        return Promise.resolve();
      }
    };
    let func = safeAsyncFunction();
    evaluatorMemo[expression] = func;
    return func;
  }
  function generateEvaluatorFromString(dataStack, expression, el) {
    let func = generateFunctionFromString(expression, el);
    return (receiver = () => {}, {
      scope: scope2 = {},
      params = []
    } = {}) => {
      func.result = void 0;
      func.finished = false;
      let completeScope = mergeProxies([scope2, ...dataStack]);
      if (typeof func === "function") {
        let promise = func(func, completeScope).catch(error2 => handleError(error2, el, expression));
        if (func.finished) {
          runIfTypeOfFunction(receiver, func.result, completeScope, params, el);
          func.result = void 0;
        } else {
          promise.then(result => {
            runIfTypeOfFunction(receiver, result, completeScope, params, el);
          }).catch(error2 => handleError(error2, el, expression)).finally(() => func.result = void 0);
        }
      }
    };
  }
  function runIfTypeOfFunction(receiver, value, scope2, params, el) {
    if (shouldAutoEvaluateFunctions && typeof value === "function") {
      let result = value.apply(scope2, params);
      if (result instanceof Promise) {
        result.then(i => runIfTypeOfFunction(receiver, i, scope2, params)).catch(error2 => handleError(error2, el, value));
      } else {
        receiver(result);
      }
    } else if (typeof value === "object" && value instanceof Promise) {
      value.then(i => receiver(i));
    } else {
      receiver(value);
    }
  }

  // packages/alpinejs/src/directives.js
  var prefixAsString = "x-";
  function prefix(subject = "") {
    return prefixAsString + subject;
  }
  function setPrefix(newPrefix) {
    prefixAsString = newPrefix;
  }
  var directiveHandlers = {};
  function directive(name, callback) {
    directiveHandlers[name] = callback;
    return {
      before(directive2) {
        if (!directiveHandlers[directive2]) {
          console.warn("Cannot find directive `${directive}`. `${name}` will use the default order of execution");
          return;
        }
        const pos = directiveOrder.indexOf(directive2);
        directiveOrder.splice(pos >= 0 ? pos : directiveOrder.indexOf("DEFAULT"), 0, name);
      }
    };
  }
  function directives(el, attributes, originalAttributeOverride) {
    attributes = Array.from(attributes);
    if (el._x_virtualDirectives) {
      let vAttributes = Object.entries(el._x_virtualDirectives).map(([name, value]) => ({
        name,
        value
      }));
      let staticAttributes = attributesOnly(vAttributes);
      vAttributes = vAttributes.map(attribute => {
        if (staticAttributes.find(attr => attr.name === attribute.name)) {
          return {
            name: `x-bind:${attribute.name}`,
            value: `"${attribute.value}"`
          };
        }
        return attribute;
      });
      attributes = attributes.concat(vAttributes);
    }
    let transformedAttributeMap = {};
    let directives2 = attributes.map(toTransformedAttributes((newName, oldName) => transformedAttributeMap[newName] = oldName)).filter(outNonAlpineAttributes).map(toParsedDirectives(transformedAttributeMap, originalAttributeOverride)).sort(byPriority);
    return directives2.map(directive2 => {
      return getDirectiveHandler(el, directive2);
    });
  }
  function attributesOnly(attributes) {
    return Array.from(attributes).map(toTransformedAttributes()).filter(attr => !outNonAlpineAttributes(attr));
  }
  var isDeferringHandlers = false;
  var directiveHandlerStacks = new Map();
  var currentHandlerStackKey = Symbol();
  function deferHandlingDirectives(callback) {
    isDeferringHandlers = true;
    let key = Symbol();
    currentHandlerStackKey = key;
    directiveHandlerStacks.set(key, []);
    let flushHandlers = () => {
      while (directiveHandlerStacks.get(key).length) directiveHandlerStacks.get(key).shift()();
      directiveHandlerStacks.delete(key);
    };
    let stopDeferring = () => {
      isDeferringHandlers = false;
      flushHandlers();
    };
    callback(flushHandlers);
    stopDeferring();
  }
  function getElementBoundUtilities(el) {
    let cleanups = [];
    let cleanup2 = callback => cleanups.push(callback);
    let [effect3, cleanupEffect] = elementBoundEffect(el);
    cleanups.push(cleanupEffect);
    let utilities = {
      Alpine: alpine_default,
      effect: effect3,
      cleanup: cleanup2,
      evaluateLater: evaluateLater.bind(evaluateLater, el),
      evaluate: evaluate.bind(evaluate, el)
    };
    let doCleanup = () => cleanups.forEach(i => i());
    return [utilities, doCleanup];
  }
  function getDirectiveHandler(el, directive2) {
    let noop = () => {};
    let handler4 = directiveHandlers[directive2.type] || noop;
    let [utilities, cleanup2] = getElementBoundUtilities(el);
    onAttributeRemoved(el, directive2.original, cleanup2);
    let fullHandler = () => {
      if (el._x_ignore || el._x_ignoreSelf) return;
      handler4.inline && handler4.inline(el, directive2, utilities);
      handler4 = handler4.bind(handler4, el, directive2, utilities);
      isDeferringHandlers ? directiveHandlerStacks.get(currentHandlerStackKey).push(handler4) : handler4();
    };
    fullHandler.runCleanups = cleanup2;
    return fullHandler;
  }
  var startingWith = (subject, replacement) => ({
    name,
    value
  }) => {
    if (name.startsWith(subject)) name = name.replace(subject, replacement);
    return {
      name,
      value
    };
  };
  var into = i => i;
  function toTransformedAttributes(callback = () => {}) {
    return ({
      name,
      value
    }) => {
      let {
        name: newName,
        value: newValue
      } = attributeTransformers.reduce((carry, transform) => {
        return transform(carry);
      }, {
        name,
        value
      });
      if (newName !== name) callback(newName, name);
      return {
        name: newName,
        value: newValue
      };
    };
  }
  var attributeTransformers = [];
  function mapAttributes(callback) {
    attributeTransformers.push(callback);
  }
  function outNonAlpineAttributes({
    name
  }) {
    return alpineAttributeRegex().test(name);
  }
  var alpineAttributeRegex = () => new RegExp(`^${prefixAsString}([^:^.]+)\\b`);
  function toParsedDirectives(transformedAttributeMap, originalAttributeOverride) {
    return ({
      name,
      value
    }) => {
      let typeMatch = name.match(alpineAttributeRegex());
      let valueMatch = name.match(/:([a-zA-Z0-9\-:]+)/);
      let modifiers = name.match(/\.[^.\]]+(?=[^\]]*$)/g) || [];
      let original = originalAttributeOverride || transformedAttributeMap[name] || name;
      return {
        type: typeMatch ? typeMatch[1] : null,
        value: valueMatch ? valueMatch[1] : null,
        modifiers: modifiers.map(i => i.replace(".", "")),
        expression: value,
        original
      };
    };
  }
  var DEFAULT = "DEFAULT";
  var directiveOrder = ["ignore", "ref", "data", "id", "bind", "init", "for", "model", "modelable", "transition", "show", "if", DEFAULT, "teleport"];
  function byPriority(a, b) {
    let typeA = directiveOrder.indexOf(a.type) === -1 ? DEFAULT : a.type;
    let typeB = directiveOrder.indexOf(b.type) === -1 ? DEFAULT : b.type;
    return directiveOrder.indexOf(typeA) - directiveOrder.indexOf(typeB);
  }

  // packages/alpinejs/src/utils/dispatch.js
  function dispatch(el, name, detail = {}) {
    el.dispatchEvent(new CustomEvent(name, {
      detail,
      bubbles: true,
      composed: true,
      cancelable: true
    }));
  }

  // packages/alpinejs/src/utils/walk.js
  function walk(el, callback) {
    if (typeof ShadowRoot === "function" && el instanceof ShadowRoot) {
      Array.from(el.children).forEach(el2 => walk(el2, callback));
      return;
    }
    let skip = false;
    callback(el, () => skip = true);
    if (skip) return;
    let node = el.firstElementChild;
    while (node) {
      walk(node, callback);
      node = node.nextElementSibling;
    }
  }

  // packages/alpinejs/src/utils/warn.js
  function warn(message, ...args) {
    console.warn(`Alpine Warning: ${message}`, ...args);
  }

  // packages/alpinejs/src/lifecycle.js
  var started = false;
  function start() {
    if (started) warn("Alpine has already been initialized on this page. Calling Alpine.start() more than once can cause problems.");
    started = true;
    if (!document.body) warn("Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?");
    dispatch(document, "alpine:init");
    dispatch(document, "alpine:initializing");
    startObservingMutations();
    onElAdded(el => initTree(el, walk));
    onElRemoved(el => destroyTree(el));
    onAttributesAdded((el, attrs) => {
      directives(el, attrs).forEach(handle => handle());
    });
    let outNestedComponents = el => !closestRoot(el.parentElement, true);
    Array.from(document.querySelectorAll(allSelectors())).filter(outNestedComponents).forEach(el => {
      initTree(el);
    });
    dispatch(document, "alpine:initialized");
  }
  var rootSelectorCallbacks = [];
  var initSelectorCallbacks = [];
  function rootSelectors() {
    return rootSelectorCallbacks.map(fn => fn());
  }
  function allSelectors() {
    return rootSelectorCallbacks.concat(initSelectorCallbacks).map(fn => fn());
  }
  function addRootSelector(selectorCallback) {
    rootSelectorCallbacks.push(selectorCallback);
  }
  function addInitSelector(selectorCallback) {
    initSelectorCallbacks.push(selectorCallback);
  }
  function closestRoot(el, includeInitSelectors = false) {
    return findClosest(el, element => {
      const selectors = includeInitSelectors ? allSelectors() : rootSelectors();
      if (selectors.some(selector => element.matches(selector))) return true;
    });
  }
  function findClosest(el, callback) {
    if (!el) return;
    if (callback(el)) return el;
    if (el._x_teleportBack) el = el._x_teleportBack;
    if (!el.parentElement) return;
    return findClosest(el.parentElement, callback);
  }
  function isRoot(el) {
    return rootSelectors().some(selector => el.matches(selector));
  }
  var initInterceptors2 = [];
  function interceptInit(callback) {
    initInterceptors2.push(callback);
  }
  function initTree(el, walker = walk, intercept = () => {}) {
    deferHandlingDirectives(() => {
      walker(el, (el2, skip) => {
        intercept(el2, skip);
        initInterceptors2.forEach(i => i(el2, skip));
        directives(el2, el2.attributes).forEach(handle => handle());
        el2._x_ignore && skip();
      });
    });
  }
  function destroyTree(root) {
    walk(root, el => cleanupAttributes(el));
  }

  // packages/alpinejs/src/nextTick.js
  var tickStack = [];
  var isHolding = false;
  function nextTick(callback = () => {}) {
    queueMicrotask(() => {
      isHolding || setTimeout(() => {
        releaseNextTicks();
      });
    });
    return new Promise(res => {
      tickStack.push(() => {
        callback();
        res();
      });
    });
  }
  function releaseNextTicks() {
    isHolding = false;
    while (tickStack.length) tickStack.shift()();
  }
  function holdNextTicks() {
    isHolding = true;
  }

  // packages/alpinejs/src/utils/classes.js
  function setClasses(el, value) {
    if (Array.isArray(value)) {
      return setClassesFromString(el, value.join(" "));
    } else if (typeof value === "object" && value !== null) {
      return setClassesFromObject(el, value);
    } else if (typeof value === "function") {
      return setClasses(el, value());
    }
    return setClassesFromString(el, value);
  }
  function setClassesFromString(el, classString) {
    let missingClasses = classString2 => classString2.split(" ").filter(i => !el.classList.contains(i)).filter(Boolean);
    let addClassesAndReturnUndo = classes => {
      el.classList.add(...classes);
      return () => {
        el.classList.remove(...classes);
      };
    };
    classString = classString === true ? classString = "" : classString || "";
    return addClassesAndReturnUndo(missingClasses(classString));
  }
  function setClassesFromObject(el, classObject) {
    let split = classString => classString.split(" ").filter(Boolean);
    let forAdd = Object.entries(classObject).flatMap(([classString, bool]) => bool ? split(classString) : false).filter(Boolean);
    let forRemove = Object.entries(classObject).flatMap(([classString, bool]) => !bool ? split(classString) : false).filter(Boolean);
    let added = [];
    let removed = [];
    forRemove.forEach(i => {
      if (el.classList.contains(i)) {
        el.classList.remove(i);
        removed.push(i);
      }
    });
    forAdd.forEach(i => {
      if (!el.classList.contains(i)) {
        el.classList.add(i);
        added.push(i);
      }
    });
    return () => {
      removed.forEach(i => el.classList.add(i));
      added.forEach(i => el.classList.remove(i));
    };
  }

  // packages/alpinejs/src/utils/styles.js
  function setStyles(el, value) {
    if (typeof value === "object" && value !== null) {
      return setStylesFromObject(el, value);
    }
    return setStylesFromString(el, value);
  }
  function setStylesFromObject(el, value) {
    let previousStyles = {};
    Object.entries(value).forEach(([key, value2]) => {
      previousStyles[key] = el.style[key];
      if (!key.startsWith("--")) {
        key = kebabCase(key);
      }
      el.style.setProperty(key, value2);
    });
    setTimeout(() => {
      if (el.style.length === 0) {
        el.removeAttribute("style");
      }
    });
    return () => {
      setStyles(el, previousStyles);
    };
  }
  function setStylesFromString(el, value) {
    let cache = el.getAttribute("style", value);
    el.setAttribute("style", value);
    return () => {
      el.setAttribute("style", cache || "");
    };
  }
  function kebabCase(subject) {
    return subject.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase();
  }

  // packages/alpinejs/src/utils/once.js
  function once(callback, fallback = () => {}) {
    let called = false;
    return function () {
      if (!called) {
        called = true;
        callback.apply(this, arguments);
      } else {
        fallback.apply(this, arguments);
      }
    };
  }

  // packages/alpinejs/src/directives/x-transition.js
  directive("transition", (el, {
    value,
    modifiers,
    expression
  }, {
    evaluate: evaluate2
  }) => {
    if (typeof expression === "function") expression = evaluate2(expression);
    if (expression === false) return;
    if (!expression || typeof expression === "boolean") {
      registerTransitionsFromHelper(el, modifiers, value);
    } else {
      registerTransitionsFromClassString(el, expression, value);
    }
  });
  function registerTransitionsFromClassString(el, classString, stage) {
    registerTransitionObject(el, setClasses, "");
    let directiveStorageMap = {
      enter: classes => {
        el._x_transition.enter.during = classes;
      },
      "enter-start": classes => {
        el._x_transition.enter.start = classes;
      },
      "enter-end": classes => {
        el._x_transition.enter.end = classes;
      },
      leave: classes => {
        el._x_transition.leave.during = classes;
      },
      "leave-start": classes => {
        el._x_transition.leave.start = classes;
      },
      "leave-end": classes => {
        el._x_transition.leave.end = classes;
      }
    };
    directiveStorageMap[stage](classString);
  }
  function registerTransitionsFromHelper(el, modifiers, stage) {
    registerTransitionObject(el, setStyles);
    let doesntSpecify = !modifiers.includes("in") && !modifiers.includes("out") && !stage;
    let transitioningIn = doesntSpecify || modifiers.includes("in") || ["enter"].includes(stage);
    let transitioningOut = doesntSpecify || modifiers.includes("out") || ["leave"].includes(stage);
    if (modifiers.includes("in") && !doesntSpecify) {
      modifiers = modifiers.filter((i, index) => index < modifiers.indexOf("out"));
    }
    if (modifiers.includes("out") && !doesntSpecify) {
      modifiers = modifiers.filter((i, index) => index > modifiers.indexOf("out"));
    }
    let wantsAll = !modifiers.includes("opacity") && !modifiers.includes("scale");
    let wantsOpacity = wantsAll || modifiers.includes("opacity");
    let wantsScale = wantsAll || modifiers.includes("scale");
    let opacityValue = wantsOpacity ? 0 : 1;
    let scaleValue = wantsScale ? modifierValue(modifiers, "scale", 95) / 100 : 1;
    let delay = modifierValue(modifiers, "delay", 0) / 1e3;
    let origin = modifierValue(modifiers, "origin", "center");
    let property = "opacity, transform";
    let durationIn = modifierValue(modifiers, "duration", 150) / 1e3;
    let durationOut = modifierValue(modifiers, "duration", 75) / 1e3;
    let easing = `cubic-bezier(0.4, 0.0, 0.2, 1)`;
    if (transitioningIn) {
      el._x_transition.enter.during = {
        transformOrigin: origin,
        transitionDelay: `${delay}s`,
        transitionProperty: property,
        transitionDuration: `${durationIn}s`,
        transitionTimingFunction: easing
      };
      el._x_transition.enter.start = {
        opacity: opacityValue,
        transform: `scale(${scaleValue})`
      };
      el._x_transition.enter.end = {
        opacity: 1,
        transform: `scale(1)`
      };
    }
    if (transitioningOut) {
      el._x_transition.leave.during = {
        transformOrigin: origin,
        transitionDelay: `${delay}s`,
        transitionProperty: property,
        transitionDuration: `${durationOut}s`,
        transitionTimingFunction: easing
      };
      el._x_transition.leave.start = {
        opacity: 1,
        transform: `scale(1)`
      };
      el._x_transition.leave.end = {
        opacity: opacityValue,
        transform: `scale(${scaleValue})`
      };
    }
  }
  function registerTransitionObject(el, setFunction, defaultValue = {}) {
    if (!el._x_transition) el._x_transition = {
      enter: {
        during: defaultValue,
        start: defaultValue,
        end: defaultValue
      },
      leave: {
        during: defaultValue,
        start: defaultValue,
        end: defaultValue
      },
      in(before = () => {}, after = () => {}) {
        transition(el, setFunction, {
          during: this.enter.during,
          start: this.enter.start,
          end: this.enter.end
        }, before, after);
      },
      out(before = () => {}, after = () => {}) {
        transition(el, setFunction, {
          during: this.leave.during,
          start: this.leave.start,
          end: this.leave.end
        }, before, after);
      }
    };
  }
  window.Element.prototype._x_toggleAndCascadeWithTransitions = function (el, value, show, hide) {
    const nextTick2 = document.visibilityState === "visible" ? requestAnimationFrame : setTimeout;
    let clickAwayCompatibleShow = () => nextTick2(show);
    if (value) {
      if (el._x_transition && (el._x_transition.enter || el._x_transition.leave)) {
        el._x_transition.enter && (Object.entries(el._x_transition.enter.during).length || Object.entries(el._x_transition.enter.start).length || Object.entries(el._x_transition.enter.end).length) ? el._x_transition.in(show) : clickAwayCompatibleShow();
      } else {
        el._x_transition ? el._x_transition.in(show) : clickAwayCompatibleShow();
      }
      return;
    }
    el._x_hidePromise = el._x_transition ? new Promise((resolve, reject) => {
      el._x_transition.out(() => {}, () => resolve(hide));
      el._x_transitioning.beforeCancel(() => reject({
        isFromCancelledTransition: true
      }));
    }) : Promise.resolve(hide);
    queueMicrotask(() => {
      let closest = closestHide(el);
      if (closest) {
        if (!closest._x_hideChildren) closest._x_hideChildren = [];
        closest._x_hideChildren.push(el);
      } else {
        nextTick2(() => {
          let hideAfterChildren = el2 => {
            let carry = Promise.all([el2._x_hidePromise, ...(el2._x_hideChildren || []).map(hideAfterChildren)]).then(([i]) => i());
            delete el2._x_hidePromise;
            delete el2._x_hideChildren;
            return carry;
          };
          hideAfterChildren(el).catch(e => {
            if (!e.isFromCancelledTransition) throw e;
          });
        });
      }
    });
  };
  function closestHide(el) {
    let parent = el.parentNode;
    if (!parent) return;
    return parent._x_hidePromise ? parent : closestHide(parent);
  }
  function transition(el, setFunction, {
    during,
    start: start2,
    end
  } = {}, before = () => {}, after = () => {}) {
    if (el._x_transitioning) el._x_transitioning.cancel();
    if (Object.keys(during).length === 0 && Object.keys(start2).length === 0 && Object.keys(end).length === 0) {
      before();
      after();
      return;
    }
    let undoStart, undoDuring, undoEnd;
    performTransition(el, {
      start() {
        undoStart = setFunction(el, start2);
      },
      during() {
        undoDuring = setFunction(el, during);
      },
      before,
      end() {
        undoStart();
        undoEnd = setFunction(el, end);
      },
      after,
      cleanup() {
        undoDuring();
        undoEnd();
      }
    });
  }
  function performTransition(el, stages) {
    let interrupted, reachedBefore, reachedEnd;
    let finish = once(() => {
      mutateDom(() => {
        interrupted = true;
        if (!reachedBefore) stages.before();
        if (!reachedEnd) {
          stages.end();
          releaseNextTicks();
        }
        stages.after();
        if (el.isConnected) stages.cleanup();
        delete el._x_transitioning;
      });
    });
    el._x_transitioning = {
      beforeCancels: [],
      beforeCancel(callback) {
        this.beforeCancels.push(callback);
      },
      cancel: once(function () {
        while (this.beforeCancels.length) {
          this.beforeCancels.shift()();
        }
        finish();
      }),
      finish
    };
    mutateDom(() => {
      stages.start();
      stages.during();
    });
    holdNextTicks();
    requestAnimationFrame(() => {
      if (interrupted) return;
      let duration = Number(getComputedStyle(el).transitionDuration.replace(/,.*/, "").replace("s", "")) * 1e3;
      let delay = Number(getComputedStyle(el).transitionDelay.replace(/,.*/, "").replace("s", "")) * 1e3;
      if (duration === 0) duration = Number(getComputedStyle(el).animationDuration.replace("s", "")) * 1e3;
      mutateDom(() => {
        stages.before();
      });
      reachedBefore = true;
      requestAnimationFrame(() => {
        if (interrupted) return;
        mutateDom(() => {
          stages.end();
        });
        releaseNextTicks();
        setTimeout(el._x_transitioning.finish, duration + delay);
        reachedEnd = true;
      });
    });
  }
  function modifierValue(modifiers, key, fallback) {
    if (modifiers.indexOf(key) === -1) return fallback;
    const rawValue = modifiers[modifiers.indexOf(key) + 1];
    if (!rawValue) return fallback;
    if (key === "scale") {
      if (isNaN(rawValue)) return fallback;
    }
    if (key === "duration" || key === "delay") {
      let match = rawValue.match(/([0-9]+)ms/);
      if (match) return match[1];
    }
    if (key === "origin") {
      if (["top", "right", "left", "center", "bottom"].includes(modifiers[modifiers.indexOf(key) + 2])) {
        return [rawValue, modifiers[modifiers.indexOf(key) + 2]].join(" ");
      }
    }
    return rawValue;
  }

  // packages/alpinejs/src/clone.js
  var isCloning = false;
  function skipDuringClone(callback, fallback = () => {}) {
    return (...args) => isCloning ? fallback(...args) : callback(...args);
  }
  function onlyDuringClone(callback) {
    return (...args) => isCloning && callback(...args);
  }
  function clone(oldEl, newEl) {
    if (!newEl._x_dataStack) newEl._x_dataStack = oldEl._x_dataStack;
    isCloning = true;
    dontRegisterReactiveSideEffects(() => {
      cloneTree(newEl);
    });
    isCloning = false;
  }
  function cloneTree(el) {
    let hasRunThroughFirstEl = false;
    let shallowWalker = (el2, callback) => {
      walk(el2, (el3, skip) => {
        if (hasRunThroughFirstEl && isRoot(el3)) return skip();
        hasRunThroughFirstEl = true;
        callback(el3, skip);
      });
    };
    initTree(el, shallowWalker);
  }
  function dontRegisterReactiveSideEffects(callback) {
    let cache = effect;
    overrideEffect((callback2, el) => {
      let storedEffect = cache(callback2);
      release(storedEffect);
      return () => {};
    });
    callback();
    overrideEffect(cache);
  }

  // packages/alpinejs/src/utils/bind.js
  function bind(el, name, value, modifiers = []) {
    if (!el._x_bindings) el._x_bindings = reactive({});
    el._x_bindings[name] = value;
    name = modifiers.includes("camel") ? camelCase(name) : name;
    switch (name) {
      case "value":
        bindInputValue(el, value);
        break;
      case "style":
        bindStyles(el, value);
        break;
      case "class":
        bindClasses(el, value);
        break;
      case "selected":
      case "checked":
        bindAttributeAndProperty(el, name, value);
        break;
      default:
        bindAttribute(el, name, value);
        break;
    }
  }
  function bindInputValue(el, value) {
    if (el.type === "radio") {
      if (el.attributes.value === void 0) {
        el.value = value;
      }
      if (window.fromModel) {
        el.checked = checkedAttrLooseCompare(el.value, value);
      }
    } else if (el.type === "checkbox") {
      if (Number.isInteger(value)) {
        el.value = value;
      } else if (!Number.isInteger(value) && !Array.isArray(value) && typeof value !== "boolean" && ![null, void 0].includes(value)) {
        el.value = String(value);
      } else {
        if (Array.isArray(value)) {
          el.checked = value.some(val => checkedAttrLooseCompare(val, el.value));
        } else {
          el.checked = !!value;
        }
      }
    } else if (el.tagName === "SELECT") {
      updateSelect(el, value);
    } else {
      if (el.value === value) return;
      el.value = value;
    }
  }
  function bindClasses(el, value) {
    if (el._x_undoAddedClasses) el._x_undoAddedClasses();
    el._x_undoAddedClasses = setClasses(el, value);
  }
  function bindStyles(el, value) {
    if (el._x_undoAddedStyles) el._x_undoAddedStyles();
    el._x_undoAddedStyles = setStyles(el, value);
  }
  function bindAttributeAndProperty(el, name, value) {
    bindAttribute(el, name, value);
    setPropertyIfChanged(el, name, value);
  }
  function bindAttribute(el, name, value) {
    if ([null, void 0, false].includes(value) && attributeShouldntBePreservedIfFalsy(name)) {
      el.removeAttribute(name);
    } else {
      if (isBooleanAttr(name)) value = name;
      setIfChanged(el, name, value);
    }
  }
  function setIfChanged(el, attrName, value) {
    if (el.getAttribute(attrName) != value) {
      el.setAttribute(attrName, value);
    }
  }
  function setPropertyIfChanged(el, propName, value) {
    if (el[propName] !== value) {
      el[propName] = value;
    }
  }
  function updateSelect(el, value) {
    const arrayWrappedValue = [].concat(value).map(value2 => {
      return value2 + "";
    });
    Array.from(el.options).forEach(option => {
      option.selected = arrayWrappedValue.includes(option.value);
    });
  }
  function camelCase(subject) {
    return subject.toLowerCase().replace(/-(\w)/g, (match, char) => char.toUpperCase());
  }
  function checkedAttrLooseCompare(valueA, valueB) {
    return valueA == valueB;
  }
  function isBooleanAttr(attrName) {
    const booleanAttributes = ["disabled", "checked", "required", "readonly", "hidden", "open", "selected", "autofocus", "itemscope", "multiple", "novalidate", "allowfullscreen", "allowpaymentrequest", "formnovalidate", "autoplay", "controls", "loop", "muted", "playsinline", "default", "ismap", "reversed", "async", "defer", "nomodule"];
    return booleanAttributes.includes(attrName);
  }
  function attributeShouldntBePreservedIfFalsy(name) {
    return !["aria-pressed", "aria-checked", "aria-expanded", "aria-selected"].includes(name);
  }
  function getBinding(el, name, fallback) {
    if (el._x_bindings && el._x_bindings[name] !== void 0) return el._x_bindings[name];
    return getAttributeBinding(el, name, fallback);
  }
  function extractProp(el, name, fallback, extract = true) {
    if (el._x_bindings && el._x_bindings[name] !== void 0) return el._x_bindings[name];
    if (el._x_inlineBindings && el._x_inlineBindings[name] !== void 0) {
      let binding = el._x_inlineBindings[name];
      binding.extract = extract;
      return dontAutoEvaluateFunctions(() => {
        return evaluate(el, binding.expression);
      });
    }
    return getAttributeBinding(el, name, fallback);
  }
  function getAttributeBinding(el, name, fallback) {
    let attr = el.getAttribute(name);
    if (attr === null) return typeof fallback === "function" ? fallback() : fallback;
    if (attr === "") return true;
    if (isBooleanAttr(name)) {
      return !![name, "true"].includes(attr);
    }
    return attr;
  }

  // packages/alpinejs/src/utils/debounce.js
  function debounce(func, wait) {
    var timeout;
    return function () {
      var context = this,
        args = arguments;
      var later = function () {
        timeout = null;
        func.apply(context, args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  // packages/alpinejs/src/utils/throttle.js
  function throttle(func, limit) {
    let inThrottle;
    return function () {
      let context = this,
        args = arguments;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => inThrottle = false, limit);
      }
    };
  }

  // packages/alpinejs/src/plugin.js
  function plugin(callback) {
    let callbacks = Array.isArray(callback) ? callback : [callback];
    callbacks.forEach(i => i(alpine_default));
  }

  // packages/alpinejs/src/store.js
  var stores = {};
  var isReactive = false;
  function store(name, value) {
    if (!isReactive) {
      stores = reactive(stores);
      isReactive = true;
    }
    if (value === void 0) {
      return stores[name];
    }
    stores[name] = value;
    if (typeof value === "object" && value !== null && value.hasOwnProperty("init") && typeof value.init === "function") {
      stores[name].init();
    }
    initInterceptors(stores[name]);
  }
  function getStores() {
    return stores;
  }

  // packages/alpinejs/src/binds.js
  var binds = {};
  function bind2(name, bindings) {
    let getBindings = typeof bindings !== "function" ? () => bindings : bindings;
    if (name instanceof Element) {
      applyBindingsObject(name, getBindings());
    } else {
      binds[name] = getBindings;
    }
  }
  function injectBindingProviders(obj) {
    Object.entries(binds).forEach(([name, callback]) => {
      Object.defineProperty(obj, name, {
        get() {
          return (...args) => {
            return callback(...args);
          };
        }
      });
    });
    return obj;
  }
  function applyBindingsObject(el, obj, original) {
    let cleanupRunners = [];
    while (cleanupRunners.length) cleanupRunners.pop()();
    let attributes = Object.entries(obj).map(([name, value]) => ({
      name,
      value
    }));
    let staticAttributes = attributesOnly(attributes);
    attributes = attributes.map(attribute => {
      if (staticAttributes.find(attr => attr.name === attribute.name)) {
        return {
          name: `x-bind:${attribute.name}`,
          value: `"${attribute.value}"`
        };
      }
      return attribute;
    });
    directives(el, attributes, original).map(handle => {
      cleanupRunners.push(handle.runCleanups);
      handle();
    });
  }

  // packages/alpinejs/src/datas.js
  var datas = {};
  function data(name, callback) {
    datas[name] = callback;
  }
  function injectDataProviders(obj, context) {
    Object.entries(datas).forEach(([name, callback]) => {
      Object.defineProperty(obj, name, {
        get() {
          return (...args) => {
            return callback.bind(context)(...args);
          };
        },
        enumerable: false
      });
    });
    return obj;
  }

  // packages/alpinejs/src/alpine.js
  var Alpine = {
    get reactive() {
      return reactive;
    },
    get release() {
      return release;
    },
    get effect() {
      return effect;
    },
    get raw() {
      return raw;
    },
    version: "3.12.3",
    flushAndStopDeferringMutations,
    dontAutoEvaluateFunctions,
    disableEffectScheduling,
    startObservingMutations,
    stopObservingMutations,
    setReactivityEngine,
    closestDataStack,
    skipDuringClone,
    onlyDuringClone,
    addRootSelector,
    addInitSelector,
    addScopeToNode,
    deferMutations,
    mapAttributes,
    evaluateLater,
    interceptInit,
    setEvaluator,
    mergeProxies,
    extractProp,
    findClosest,
    closestRoot,
    destroyTree,
    interceptor,
    transition,
    setStyles,
    mutateDom,
    directive,
    throttle,
    debounce,
    evaluate,
    initTree,
    nextTick,
    prefixed: prefix,
    prefix: setPrefix,
    plugin,
    magic,
    store,
    start,
    clone,
    bound: getBinding,
    $data: scope,
    walk,
    data,
    bind: bind2
  };
  var alpine_default = Alpine;

  // node_modules/@vue/shared/dist/shared.esm-bundler.js
  function makeMap(str, expectsLowerCase) {
    const map = Object.create(null);
    const list = str.split(",");
    for (let i = 0; i < list.length; i++) {
      map[list[i]] = true;
    }
    return expectsLowerCase ? val => !!map[val.toLowerCase()] : val => !!map[val];
  }
  var EMPTY_OBJ = Object.freeze({}) ;
  var extend = Object.assign;
  var hasOwnProperty = Object.prototype.hasOwnProperty;
  var hasOwn = (val, key) => hasOwnProperty.call(val, key);
  var isArray = Array.isArray;
  var isMap = val => toTypeString(val) === "[object Map]";
  var isString = val => typeof val === "string";
  var isSymbol = val => typeof val === "symbol";
  var isObject = val => val !== null && typeof val === "object";
  var objectToString = Object.prototype.toString;
  var toTypeString = value => objectToString.call(value);
  var toRawType = value => {
    return toTypeString(value).slice(8, -1);
  };
  var isIntegerKey = key => isString(key) && key !== "NaN" && key[0] !== "-" && "" + parseInt(key, 10) === key;
  var cacheStringFunction = fn => {
    const cache = Object.create(null);
    return str => {
      const hit = cache[str];
      return hit || (cache[str] = fn(str));
    };
  };
  var capitalize = cacheStringFunction(str => str.charAt(0).toUpperCase() + str.slice(1));
  var hasChanged = (value, oldValue) => value !== oldValue && (value === value || oldValue === oldValue);

  // node_modules/@vue/reactivity/dist/reactivity.esm-bundler.js
  var targetMap = new WeakMap();
  var effectStack = [];
  var activeEffect;
  var ITERATE_KEY = Symbol("iterate" );
  var MAP_KEY_ITERATE_KEY = Symbol("Map key iterate" );
  function isEffect(fn) {
    return fn && fn._isEffect === true;
  }
  function effect2(fn, options = EMPTY_OBJ) {
    if (isEffect(fn)) {
      fn = fn.raw;
    }
    const effect3 = createReactiveEffect(fn, options);
    if (!options.lazy) {
      effect3();
    }
    return effect3;
  }
  function stop(effect3) {
    if (effect3.active) {
      cleanup(effect3);
      if (effect3.options.onStop) {
        effect3.options.onStop();
      }
      effect3.active = false;
    }
  }
  var uid = 0;
  function createReactiveEffect(fn, options) {
    const effect3 = function reactiveEffect() {
      if (!effect3.active) {
        return fn();
      }
      if (!effectStack.includes(effect3)) {
        cleanup(effect3);
        try {
          enableTracking();
          effectStack.push(effect3);
          activeEffect = effect3;
          return fn();
        } finally {
          effectStack.pop();
          resetTracking();
          activeEffect = effectStack[effectStack.length - 1];
        }
      }
    };
    effect3.id = uid++;
    effect3.allowRecurse = !!options.allowRecurse;
    effect3._isEffect = true;
    effect3.active = true;
    effect3.raw = fn;
    effect3.deps = [];
    effect3.options = options;
    return effect3;
  }
  function cleanup(effect3) {
    const {
      deps
    } = effect3;
    if (deps.length) {
      for (let i = 0; i < deps.length; i++) {
        deps[i].delete(effect3);
      }
      deps.length = 0;
    }
  }
  var shouldTrack = true;
  var trackStack = [];
  function pauseTracking() {
    trackStack.push(shouldTrack);
    shouldTrack = false;
  }
  function enableTracking() {
    trackStack.push(shouldTrack);
    shouldTrack = true;
  }
  function resetTracking() {
    const last = trackStack.pop();
    shouldTrack = last === void 0 ? true : last;
  }
  function track(target, type, key) {
    if (!shouldTrack || activeEffect === void 0) {
      return;
    }
    let depsMap = targetMap.get(target);
    if (!depsMap) {
      targetMap.set(target, depsMap = new Map());
    }
    let dep = depsMap.get(key);
    if (!dep) {
      depsMap.set(key, dep = new Set());
    }
    if (!dep.has(activeEffect)) {
      dep.add(activeEffect);
      activeEffect.deps.push(dep);
      if (activeEffect.options.onTrack) {
        activeEffect.options.onTrack({
          effect: activeEffect,
          target,
          type,
          key
        });
      }
    }
  }
  function trigger(target, type, key, newValue, oldValue, oldTarget) {
    const depsMap = targetMap.get(target);
    if (!depsMap) {
      return;
    }
    const effects = new Set();
    const add2 = effectsToAdd => {
      if (effectsToAdd) {
        effectsToAdd.forEach(effect3 => {
          if (effect3 !== activeEffect || effect3.allowRecurse) {
            effects.add(effect3);
          }
        });
      }
    };
    if (type === "clear") {
      depsMap.forEach(add2);
    } else if (key === "length" && isArray(target)) {
      depsMap.forEach((dep, key2) => {
        if (key2 === "length" || key2 >= newValue) {
          add2(dep);
        }
      });
    } else {
      if (key !== void 0) {
        add2(depsMap.get(key));
      }
      switch (type) {
        case "add":
          if (!isArray(target)) {
            add2(depsMap.get(ITERATE_KEY));
            if (isMap(target)) {
              add2(depsMap.get(MAP_KEY_ITERATE_KEY));
            }
          } else if (isIntegerKey(key)) {
            add2(depsMap.get("length"));
          }
          break;
        case "delete":
          if (!isArray(target)) {
            add2(depsMap.get(ITERATE_KEY));
            if (isMap(target)) {
              add2(depsMap.get(MAP_KEY_ITERATE_KEY));
            }
          }
          break;
        case "set":
          if (isMap(target)) {
            add2(depsMap.get(ITERATE_KEY));
          }
          break;
      }
    }
    const run = effect3 => {
      if (effect3.options.onTrigger) {
        effect3.options.onTrigger({
          effect: effect3,
          target,
          key,
          type,
          newValue,
          oldValue,
          oldTarget
        });
      }
      if (effect3.options.scheduler) {
        effect3.options.scheduler(effect3);
      } else {
        effect3();
      }
    };
    effects.forEach(run);
  }
  var isNonTrackableKeys = /* @__PURE__ */makeMap(`__proto__,__v_isRef,__isVue`);
  var builtInSymbols = new Set(Object.getOwnPropertyNames(Symbol).map(key => Symbol[key]).filter(isSymbol));
  var get2 = /* @__PURE__ */createGetter();
  var shallowGet = /* @__PURE__ */createGetter(false, true);
  var readonlyGet = /* @__PURE__ */createGetter(true);
  var shallowReadonlyGet = /* @__PURE__ */createGetter(true, true);
  var arrayInstrumentations = {};
  ["includes", "indexOf", "lastIndexOf"].forEach(key => {
    const method = Array.prototype[key];
    arrayInstrumentations[key] = function (...args) {
      const arr = toRaw(this);
      for (let i = 0, l = this.length; i < l; i++) {
        track(arr, "get", i + "");
      }
      const res = method.apply(arr, args);
      if (res === -1 || res === false) {
        return method.apply(arr, args.map(toRaw));
      } else {
        return res;
      }
    };
  });
  ["push", "pop", "shift", "unshift", "splice"].forEach(key => {
    const method = Array.prototype[key];
    arrayInstrumentations[key] = function (...args) {
      pauseTracking();
      const res = method.apply(this, args);
      resetTracking();
      return res;
    };
  });
  function createGetter(isReadonly = false, shallow = false) {
    return function get3(target, key, receiver) {
      if (key === "__v_isReactive") {
        return !isReadonly;
      } else if (key === "__v_isReadonly") {
        return isReadonly;
      } else if (key === "__v_raw" && receiver === (isReadonly ? shallow ? shallowReadonlyMap : readonlyMap : shallow ? shallowReactiveMap : reactiveMap).get(target)) {
        return target;
      }
      const targetIsArray = isArray(target);
      if (!isReadonly && targetIsArray && hasOwn(arrayInstrumentations, key)) {
        return Reflect.get(arrayInstrumentations, key, receiver);
      }
      const res = Reflect.get(target, key, receiver);
      if (isSymbol(key) ? builtInSymbols.has(key) : isNonTrackableKeys(key)) {
        return res;
      }
      if (!isReadonly) {
        track(target, "get", key);
      }
      if (shallow) {
        return res;
      }
      if (isRef(res)) {
        const shouldUnwrap = !targetIsArray || !isIntegerKey(key);
        return shouldUnwrap ? res.value : res;
      }
      if (isObject(res)) {
        return isReadonly ? readonly(res) : reactive2(res);
      }
      return res;
    };
  }
  var set2 = /* @__PURE__ */createSetter();
  var shallowSet = /* @__PURE__ */createSetter(true);
  function createSetter(shallow = false) {
    return function set3(target, key, value, receiver) {
      let oldValue = target[key];
      if (!shallow) {
        value = toRaw(value);
        oldValue = toRaw(oldValue);
        if (!isArray(target) && isRef(oldValue) && !isRef(value)) {
          oldValue.value = value;
          return true;
        }
      }
      const hadKey = isArray(target) && isIntegerKey(key) ? Number(key) < target.length : hasOwn(target, key);
      const result = Reflect.set(target, key, value, receiver);
      if (target === toRaw(receiver)) {
        if (!hadKey) {
          trigger(target, "add", key, value);
        } else if (hasChanged(value, oldValue)) {
          trigger(target, "set", key, value, oldValue);
        }
      }
      return result;
    };
  }
  function deleteProperty(target, key) {
    const hadKey = hasOwn(target, key);
    const oldValue = target[key];
    const result = Reflect.deleteProperty(target, key);
    if (result && hadKey) {
      trigger(target, "delete", key, void 0, oldValue);
    }
    return result;
  }
  function has(target, key) {
    const result = Reflect.has(target, key);
    if (!isSymbol(key) || !builtInSymbols.has(key)) {
      track(target, "has", key);
    }
    return result;
  }
  function ownKeys$1(target) {
    track(target, "iterate", isArray(target) ? "length" : ITERATE_KEY);
    return Reflect.ownKeys(target);
  }
  var mutableHandlers = {
    get: get2,
    set: set2,
    deleteProperty,
    has,
    ownKeys: ownKeys$1
  };
  var readonlyHandlers = {
    get: readonlyGet,
    set(target, key) {
      {
        console.warn(`Set operation on key "${String(key)}" failed: target is readonly.`, target);
      }
      return true;
    },
    deleteProperty(target, key) {
      {
        console.warn(`Delete operation on key "${String(key)}" failed: target is readonly.`, target);
      }
      return true;
    }
  };
  extend({}, mutableHandlers, {
    get: shallowGet,
    set: shallowSet
  });
  extend({}, readonlyHandlers, {
    get: shallowReadonlyGet
  });
  var toReactive = value => isObject(value) ? reactive2(value) : value;
  var toReadonly = value => isObject(value) ? readonly(value) : value;
  var toShallow = value => value;
  var getProto = v => Reflect.getPrototypeOf(v);
  function get$1(target, key, isReadonly = false, isShallow = false) {
    target = target["__v_raw"];
    const rawTarget = toRaw(target);
    const rawKey = toRaw(key);
    if (key !== rawKey) {
      !isReadonly && track(rawTarget, "get", key);
    }
    !isReadonly && track(rawTarget, "get", rawKey);
    const {
      has: has2
    } = getProto(rawTarget);
    const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
    if (has2.call(rawTarget, key)) {
      return wrap(target.get(key));
    } else if (has2.call(rawTarget, rawKey)) {
      return wrap(target.get(rawKey));
    } else if (target !== rawTarget) {
      target.get(key);
    }
  }
  function has$1(key, isReadonly = false) {
    const target = this["__v_raw"];
    const rawTarget = toRaw(target);
    const rawKey = toRaw(key);
    if (key !== rawKey) {
      !isReadonly && track(rawTarget, "has", key);
    }
    !isReadonly && track(rawTarget, "has", rawKey);
    return key === rawKey ? target.has(key) : target.has(key) || target.has(rawKey);
  }
  function size(target, isReadonly = false) {
    target = target["__v_raw"];
    !isReadonly && track(toRaw(target), "iterate", ITERATE_KEY);
    return Reflect.get(target, "size", target);
  }
  function add(value) {
    value = toRaw(value);
    const target = toRaw(this);
    const proto = getProto(target);
    const hadKey = proto.has.call(target, value);
    if (!hadKey) {
      target.add(value);
      trigger(target, "add", value, value);
    }
    return this;
  }
  function set$1(key, value) {
    value = toRaw(value);
    const target = toRaw(this);
    const {
      has: has2,
      get: get3
    } = getProto(target);
    let hadKey = has2.call(target, key);
    if (!hadKey) {
      key = toRaw(key);
      hadKey = has2.call(target, key);
    } else {
      checkIdentityKeys(target, has2, key);
    }
    const oldValue = get3.call(target, key);
    target.set(key, value);
    if (!hadKey) {
      trigger(target, "add", key, value);
    } else if (hasChanged(value, oldValue)) {
      trigger(target, "set", key, value, oldValue);
    }
    return this;
  }
  function deleteEntry(key) {
    const target = toRaw(this);
    const {
      has: has2,
      get: get3
    } = getProto(target);
    let hadKey = has2.call(target, key);
    if (!hadKey) {
      key = toRaw(key);
      hadKey = has2.call(target, key);
    } else {
      checkIdentityKeys(target, has2, key);
    }
    const oldValue = get3 ? get3.call(target, key) : void 0;
    const result = target.delete(key);
    if (hadKey) {
      trigger(target, "delete", key, void 0, oldValue);
    }
    return result;
  }
  function clear() {
    const target = toRaw(this);
    const hadItems = target.size !== 0;
    const oldTarget = isMap(target) ? new Map(target) : new Set(target) ;
    const result = target.clear();
    if (hadItems) {
      trigger(target, "clear", void 0, void 0, oldTarget);
    }
    return result;
  }
  function createForEach(isReadonly, isShallow) {
    return function forEach(callback, thisArg) {
      const observed = this;
      const target = observed["__v_raw"];
      const rawTarget = toRaw(target);
      const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
      !isReadonly && track(rawTarget, "iterate", ITERATE_KEY);
      return target.forEach((value, key) => {
        return callback.call(thisArg, wrap(value), wrap(key), observed);
      });
    };
  }
  function createIterableMethod(method, isReadonly, isShallow) {
    return function (...args) {
      const target = this["__v_raw"];
      const rawTarget = toRaw(target);
      const targetIsMap = isMap(rawTarget);
      const isPair = method === "entries" || method === Symbol.iterator && targetIsMap;
      const isKeyOnly = method === "keys" && targetIsMap;
      const innerIterator = target[method](...args);
      const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
      !isReadonly && track(rawTarget, "iterate", isKeyOnly ? MAP_KEY_ITERATE_KEY : ITERATE_KEY);
      return {
        next() {
          const {
            value,
            done
          } = innerIterator.next();
          return done ? {
            value,
            done
          } : {
            value: isPair ? [wrap(value[0]), wrap(value[1])] : wrap(value),
            done
          };
        },
        [Symbol.iterator]() {
          return this;
        }
      };
    };
  }
  function createReadonlyMethod(type) {
    return function (...args) {
      {
        const key = args[0] ? `on key "${args[0]}" ` : ``;
        console.warn(`${capitalize(type)} operation ${key}failed: target is readonly.`, toRaw(this));
      }
      return type === "delete" ? false : this;
    };
  }
  var mutableInstrumentations = {
    get(key) {
      return get$1(this, key);
    },
    get size() {
      return size(this);
    },
    has: has$1,
    add,
    set: set$1,
    delete: deleteEntry,
    clear,
    forEach: createForEach(false, false)
  };
  var shallowInstrumentations = {
    get(key) {
      return get$1(this, key, false, true);
    },
    get size() {
      return size(this);
    },
    has: has$1,
    add,
    set: set$1,
    delete: deleteEntry,
    clear,
    forEach: createForEach(false, true)
  };
  var readonlyInstrumentations = {
    get(key) {
      return get$1(this, key, true);
    },
    get size() {
      return size(this, true);
    },
    has(key) {
      return has$1.call(this, key, true);
    },
    add: createReadonlyMethod("add"),
    set: createReadonlyMethod("set"),
    delete: createReadonlyMethod("delete"),
    clear: createReadonlyMethod("clear"),
    forEach: createForEach(true, false)
  };
  var shallowReadonlyInstrumentations = {
    get(key) {
      return get$1(this, key, true, true);
    },
    get size() {
      return size(this, true);
    },
    has(key) {
      return has$1.call(this, key, true);
    },
    add: createReadonlyMethod("add"),
    set: createReadonlyMethod("set"),
    delete: createReadonlyMethod("delete"),
    clear: createReadonlyMethod("clear"),
    forEach: createForEach(true, true)
  };
  var iteratorMethods = ["keys", "values", "entries", Symbol.iterator];
  iteratorMethods.forEach(method => {
    mutableInstrumentations[method] = createIterableMethod(method, false, false);
    readonlyInstrumentations[method] = createIterableMethod(method, true, false);
    shallowInstrumentations[method] = createIterableMethod(method, false, true);
    shallowReadonlyInstrumentations[method] = createIterableMethod(method, true, true);
  });
  function createInstrumentationGetter(isReadonly, shallow) {
    const instrumentations = shallow ? isReadonly ? shallowReadonlyInstrumentations : shallowInstrumentations : isReadonly ? readonlyInstrumentations : mutableInstrumentations;
    return (target, key, receiver) => {
      if (key === "__v_isReactive") {
        return !isReadonly;
      } else if (key === "__v_isReadonly") {
        return isReadonly;
      } else if (key === "__v_raw") {
        return target;
      }
      return Reflect.get(hasOwn(instrumentations, key) && key in target ? instrumentations : target, key, receiver);
    };
  }
  var mutableCollectionHandlers = {
    get: createInstrumentationGetter(false, false)
  };
  var readonlyCollectionHandlers = {
    get: createInstrumentationGetter(true, false)
  };
  function checkIdentityKeys(target, has2, key) {
    const rawKey = toRaw(key);
    if (rawKey !== key && has2.call(target, rawKey)) {
      const type = toRawType(target);
      console.warn(`Reactive ${type} contains both the raw and reactive versions of the same object${type === `Map` ? ` as keys` : ``}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`);
    }
  }
  var reactiveMap = new WeakMap();
  var shallowReactiveMap = new WeakMap();
  var readonlyMap = new WeakMap();
  var shallowReadonlyMap = new WeakMap();
  function targetTypeMap(rawType) {
    switch (rawType) {
      case "Object":
      case "Array":
        return 1;
      case "Map":
      case "Set":
      case "WeakMap":
      case "WeakSet":
        return 2;
      default:
        return 0;
    }
  }
  function getTargetType(value) {
    return value["__v_skip"] || !Object.isExtensible(value) ? 0 : targetTypeMap(toRawType(value));
  }
  function reactive2(target) {
    if (target && target["__v_isReadonly"]) {
      return target;
    }
    return createReactiveObject(target, false, mutableHandlers, mutableCollectionHandlers, reactiveMap);
  }
  function readonly(target) {
    return createReactiveObject(target, true, readonlyHandlers, readonlyCollectionHandlers, readonlyMap);
  }
  function createReactiveObject(target, isReadonly, baseHandlers, collectionHandlers, proxyMap) {
    if (!isObject(target)) {
      {
        console.warn(`value cannot be made reactive: ${String(target)}`);
      }
      return target;
    }
    if (target["__v_raw"] && !(isReadonly && target["__v_isReactive"])) {
      return target;
    }
    const existingProxy = proxyMap.get(target);
    if (existingProxy) {
      return existingProxy;
    }
    const targetType = getTargetType(target);
    if (targetType === 0) {
      return target;
    }
    const proxy = new Proxy(target, targetType === 2 ? collectionHandlers : baseHandlers);
    proxyMap.set(target, proxy);
    return proxy;
  }
  function toRaw(observed) {
    return observed && toRaw(observed["__v_raw"]) || observed;
  }
  function isRef(r) {
    return Boolean(r && r.__v_isRef === true);
  }

  // packages/alpinejs/src/magics/$nextTick.js
  magic("nextTick", () => nextTick);

  // packages/alpinejs/src/magics/$dispatch.js
  magic("dispatch", el => dispatch.bind(dispatch, el));

  // packages/alpinejs/src/magics/$watch.js
  magic("watch", (el, {
    evaluateLater: evaluateLater2,
    effect: effect3
  }) => (key, callback) => {
    let evaluate2 = evaluateLater2(key);
    let firstTime = true;
    let oldValue;
    let effectReference = effect3(() => evaluate2(value => {
      JSON.stringify(value);
      if (!firstTime) {
        queueMicrotask(() => {
          callback(value, oldValue);
          oldValue = value;
        });
      } else {
        oldValue = value;
      }
      firstTime = false;
    }));
    el._x_effects.delete(effectReference);
  });

  // packages/alpinejs/src/magics/$store.js
  magic("store", getStores);

  // packages/alpinejs/src/magics/$data.js
  magic("data", el => scope(el));

  // packages/alpinejs/src/magics/$root.js
  magic("root", el => closestRoot(el));

  // packages/alpinejs/src/magics/$refs.js
  magic("refs", el => {
    if (el._x_refs_proxy) return el._x_refs_proxy;
    el._x_refs_proxy = mergeProxies(getArrayOfRefObject(el));
    return el._x_refs_proxy;
  });
  function getArrayOfRefObject(el) {
    let refObjects = [];
    let currentEl = el;
    while (currentEl) {
      if (currentEl._x_refs) refObjects.push(currentEl._x_refs);
      currentEl = currentEl.parentNode;
    }
    return refObjects;
  }

  // packages/alpinejs/src/ids.js
  var globalIdMemo = {};
  function findAndIncrementId(name) {
    if (!globalIdMemo[name]) globalIdMemo[name] = 0;
    return ++globalIdMemo[name];
  }
  function closestIdRoot(el, name) {
    return findClosest(el, element => {
      if (element._x_ids && element._x_ids[name]) return true;
    });
  }
  function setIdRoot(el, name) {
    if (!el._x_ids) el._x_ids = {};
    if (!el._x_ids[name]) el._x_ids[name] = findAndIncrementId(name);
  }

  // packages/alpinejs/src/magics/$id.js
  magic("id", el => (name, key = null) => {
    let root = closestIdRoot(el, name);
    let id = root ? root._x_ids[name] : findAndIncrementId(name);
    return key ? `${name}-${id}-${key}` : `${name}-${id}`;
  });

  // packages/alpinejs/src/magics/$el.js
  magic("el", el => el);

  // packages/alpinejs/src/magics/index.js
  warnMissingPluginMagic("Focus", "focus", "focus");
  warnMissingPluginMagic("Persist", "persist", "persist");
  function warnMissingPluginMagic(name, magicName, slug) {
    magic(magicName, el => warn(`You can't use [$${directiveName}] without first installing the "${name}" plugin here: https://alpinejs.dev/plugins/${slug}`, el));
  }

  // packages/alpinejs/src/entangle.js
  function entangle({
    get: outerGet,
    set: outerSet
  }, {
    get: innerGet,
    set: innerSet
  }) {
    let firstRun = true;
    let outerHash, outerHashLatest;
    let reference = effect(() => {
      let outer, inner;
      if (firstRun) {
        outer = outerGet();
        innerSet(outer);
        inner = innerGet();
        firstRun = false;
      } else {
        outer = outerGet();
        inner = innerGet();
        outerHashLatest = JSON.stringify(outer);
        JSON.stringify(inner);
        if (outerHashLatest !== outerHash) {
          inner = innerGet();
          innerSet(outer);
          inner = outer;
        } else {
          outerSet(inner);
          outer = inner;
        }
      }
      outerHash = JSON.stringify(outer);
      JSON.stringify(inner);
    });
    return () => {
      release(reference);
    };
  }

  // packages/alpinejs/src/directives/x-modelable.js
  directive("modelable", (el, {
    expression
  }, {
    effect: effect3,
    evaluateLater: evaluateLater2,
    cleanup: cleanup2
  }) => {
    let func = evaluateLater2(expression);
    let innerGet = () => {
      let result;
      func(i => result = i);
      return result;
    };
    let evaluateInnerSet = evaluateLater2(`${expression} = __placeholder`);
    let innerSet = val => evaluateInnerSet(() => {}, {
      scope: {
        __placeholder: val
      }
    });
    let initialValue = innerGet();
    innerSet(initialValue);
    queueMicrotask(() => {
      if (!el._x_model) return;
      el._x_removeModelListeners["default"]();
      let outerGet = el._x_model.get;
      let outerSet = el._x_model.set;
      let releaseEntanglement = entangle({
        get() {
          return outerGet();
        },
        set(value) {
          outerSet(value);
        }
      }, {
        get() {
          return innerGet();
        },
        set(value) {
          innerSet(value);
        }
      });
      cleanup2(releaseEntanglement);
    });
  });

  // packages/alpinejs/src/directives/x-teleport.js
  var teleportContainerDuringClone = document.createElement("div");
  directive("teleport", (el, {
    modifiers,
    expression
  }, {
    cleanup: cleanup2
  }) => {
    if (el.tagName.toLowerCase() !== "template") warn("x-teleport can only be used on a <template> tag", el);
    let target = skipDuringClone(() => {
      return document.querySelector(expression);
    }, () => {
      return teleportContainerDuringClone;
    })();
    if (!target) warn(`Cannot find x-teleport element for selector: "${expression}"`);
    let clone2 = el.content.cloneNode(true).firstElementChild;
    el._x_teleport = clone2;
    clone2._x_teleportBack = el;
    if (el._x_forwardEvents) {
      el._x_forwardEvents.forEach(eventName => {
        clone2.addEventListener(eventName, e => {
          e.stopPropagation();
          el.dispatchEvent(new e.constructor(e.type, e));
        });
      });
    }
    addScopeToNode(clone2, {}, el);
    mutateDom(() => {
      if (modifiers.includes("prepend")) {
        target.parentNode.insertBefore(clone2, target);
      } else if (modifiers.includes("append")) {
        target.parentNode.insertBefore(clone2, target.nextSibling);
      } else {
        target.appendChild(clone2);
      }
      initTree(clone2);
      clone2._x_ignore = true;
    });
    cleanup2(() => clone2.remove());
  });

  // packages/alpinejs/src/directives/x-ignore.js
  var handler = () => {};
  handler.inline = (el, {
    modifiers
  }, {
    cleanup: cleanup2
  }) => {
    modifiers.includes("self") ? el._x_ignoreSelf = true : el._x_ignore = true;
    cleanup2(() => {
      modifiers.includes("self") ? delete el._x_ignoreSelf : delete el._x_ignore;
    });
  };
  directive("ignore", handler);

  // packages/alpinejs/src/directives/x-effect.js
  directive("effect", (el, {
    expression
  }, {
    effect: effect3
  }) => effect3(evaluateLater(el, expression)));

  // packages/alpinejs/src/utils/on.js
  function on(el, event, modifiers, callback) {
    let listenerTarget = el;
    let handler4 = e => callback(e);
    let options = {};
    let wrapHandler = (callback2, wrapper) => e => wrapper(callback2, e);
    if (modifiers.includes("dot")) event = dotSyntax(event);
    if (modifiers.includes("camel")) event = camelCase2(event);
    if (modifiers.includes("passive")) options.passive = true;
    if (modifiers.includes("capture")) options.capture = true;
    if (modifiers.includes("window")) listenerTarget = window;
    if (modifiers.includes("document")) listenerTarget = document;
    if (modifiers.includes("debounce")) {
      let nextModifier = modifiers[modifiers.indexOf("debounce") + 1] || "invalid-wait";
      let wait = isNumeric(nextModifier.split("ms")[0]) ? Number(nextModifier.split("ms")[0]) : 250;
      handler4 = debounce(handler4, wait);
    }
    if (modifiers.includes("throttle")) {
      let nextModifier = modifiers[modifiers.indexOf("throttle") + 1] || "invalid-wait";
      let wait = isNumeric(nextModifier.split("ms")[0]) ? Number(nextModifier.split("ms")[0]) : 250;
      handler4 = throttle(handler4, wait);
    }
    if (modifiers.includes("prevent")) handler4 = wrapHandler(handler4, (next, e) => {
      e.preventDefault();
      next(e);
    });
    if (modifiers.includes("stop")) handler4 = wrapHandler(handler4, (next, e) => {
      e.stopPropagation();
      next(e);
    });
    if (modifiers.includes("self")) handler4 = wrapHandler(handler4, (next, e) => {
      e.target === el && next(e);
    });
    if (modifiers.includes("away") || modifiers.includes("outside")) {
      listenerTarget = document;
      handler4 = wrapHandler(handler4, (next, e) => {
        if (el.contains(e.target)) return;
        if (e.target.isConnected === false) return;
        if (el.offsetWidth < 1 && el.offsetHeight < 1) return;
        if (el._x_isShown === false) return;
        next(e);
      });
    }
    if (modifiers.includes("once")) {
      handler4 = wrapHandler(handler4, (next, e) => {
        next(e);
        listenerTarget.removeEventListener(event, handler4, options);
      });
    }
    handler4 = wrapHandler(handler4, (next, e) => {
      if (isKeyEvent(event)) {
        if (isListeningForASpecificKeyThatHasntBeenPressed(e, modifiers)) {
          return;
        }
      }
      next(e);
    });
    listenerTarget.addEventListener(event, handler4, options);
    return () => {
      listenerTarget.removeEventListener(event, handler4, options);
    };
  }
  function dotSyntax(subject) {
    return subject.replace(/-/g, ".");
  }
  function camelCase2(subject) {
    return subject.toLowerCase().replace(/-(\w)/g, (match, char) => char.toUpperCase());
  }
  function isNumeric(subject) {
    return !Array.isArray(subject) && !isNaN(subject);
  }
  function kebabCase2(subject) {
    if ([" ", "_"].includes(subject)) return subject;
    return subject.replace(/([a-z])([A-Z])/g, "$1-$2").replace(/[_\s]/, "-").toLowerCase();
  }
  function isKeyEvent(event) {
    return ["keydown", "keyup"].includes(event);
  }
  function isListeningForASpecificKeyThatHasntBeenPressed(e, modifiers) {
    let keyModifiers = modifiers.filter(i => {
      return !["window", "document", "prevent", "stop", "once", "capture"].includes(i);
    });
    if (keyModifiers.includes("debounce")) {
      let debounceIndex = keyModifiers.indexOf("debounce");
      keyModifiers.splice(debounceIndex, isNumeric((keyModifiers[debounceIndex + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1);
    }
    if (keyModifiers.includes("throttle")) {
      let debounceIndex = keyModifiers.indexOf("throttle");
      keyModifiers.splice(debounceIndex, isNumeric((keyModifiers[debounceIndex + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1);
    }
    if (keyModifiers.length === 0) return false;
    if (keyModifiers.length === 1 && keyToModifiers(e.key).includes(keyModifiers[0])) return false;
    const systemKeyModifiers = ["ctrl", "shift", "alt", "meta", "cmd", "super"];
    const selectedSystemKeyModifiers = systemKeyModifiers.filter(modifier => keyModifiers.includes(modifier));
    keyModifiers = keyModifiers.filter(i => !selectedSystemKeyModifiers.includes(i));
    if (selectedSystemKeyModifiers.length > 0) {
      const activelyPressedKeyModifiers = selectedSystemKeyModifiers.filter(modifier => {
        if (modifier === "cmd" || modifier === "super") modifier = "meta";
        return e[`${modifier}Key`];
      });
      if (activelyPressedKeyModifiers.length === selectedSystemKeyModifiers.length) {
        if (keyToModifiers(e.key).includes(keyModifiers[0])) return false;
      }
    }
    return true;
  }
  function keyToModifiers(key) {
    if (!key) return [];
    key = kebabCase2(key);
    let modifierToKeyMap = {
      ctrl: "control",
      slash: "/",
      space: " ",
      spacebar: " ",
      cmd: "meta",
      esc: "escape",
      up: "arrow-up",
      down: "arrow-down",
      left: "arrow-left",
      right: "arrow-right",
      period: ".",
      equal: "=",
      minus: "-",
      underscore: "_"
    };
    modifierToKeyMap[key] = key;
    return Object.keys(modifierToKeyMap).map(modifier => {
      if (modifierToKeyMap[modifier] === key) return modifier;
    }).filter(modifier => modifier);
  }

  // packages/alpinejs/src/directives/x-model.js
  directive("model", (el, {
    modifiers,
    expression
  }, {
    effect: effect3,
    cleanup: cleanup2
  }) => {
    let scopeTarget = el;
    if (modifiers.includes("parent")) {
      scopeTarget = el.parentNode;
    }
    let evaluateGet = evaluateLater(scopeTarget, expression);
    let evaluateSet;
    if (typeof expression === "string") {
      evaluateSet = evaluateLater(scopeTarget, `${expression} = __placeholder`);
    } else if (typeof expression === "function" && typeof expression() === "string") {
      evaluateSet = evaluateLater(scopeTarget, `${expression()} = __placeholder`);
    } else {
      evaluateSet = () => {};
    }
    let getValue = () => {
      let result;
      evaluateGet(value => result = value);
      return isGetterSetter(result) ? result.get() : result;
    };
    let setValue = value => {
      let result;
      evaluateGet(value2 => result = value2);
      if (isGetterSetter(result)) {
        result.set(value);
      } else {
        evaluateSet(() => {}, {
          scope: {
            __placeholder: value
          }
        });
      }
    };
    if (typeof expression === "string" && el.type === "radio") {
      mutateDom(() => {
        if (!el.hasAttribute("name")) el.setAttribute("name", expression);
      });
    }
    var event = el.tagName.toLowerCase() === "select" || ["checkbox", "radio"].includes(el.type) || modifiers.includes("lazy") ? "change" : "input";
    let removeListener = isCloning ? () => {} : on(el, event, modifiers, e => {
      setValue(getInputValue(el, modifiers, e, getValue()));
    });
    if (modifiers.includes("fill") && [null, ""].includes(getValue())) {
      el.dispatchEvent(new Event(event, {}));
    }
    if (!el._x_removeModelListeners) el._x_removeModelListeners = {};
    el._x_removeModelListeners["default"] = removeListener;
    cleanup2(() => el._x_removeModelListeners["default"]());
    if (el.form) {
      let removeResetListener = on(el.form, "reset", [], e => {
        nextTick(() => el._x_model && el._x_model.set(el.value));
      });
      cleanup2(() => removeResetListener());
    }
    el._x_model = {
      get() {
        return getValue();
      },
      set(value) {
        setValue(value);
      }
    };
    el._x_forceModelUpdate = value => {
      value = value === void 0 ? getValue() : value;
      if (value === void 0 && typeof expression === "string" && expression.match(/\./)) value = "";
      window.fromModel = true;
      mutateDom(() => bind(el, "value", value));
      delete window.fromModel;
    };
    effect3(() => {
      let value = getValue();
      if (modifiers.includes("unintrusive") && document.activeElement.isSameNode(el)) return;
      el._x_forceModelUpdate(value);
    });
  });
  function getInputValue(el, modifiers, event, currentValue) {
    return mutateDom(() => {
      if (event instanceof CustomEvent && event.detail !== void 0) return event.detail ?? event.target.value;else if (el.type === "checkbox") {
        if (Array.isArray(currentValue)) {
          let newValue = modifiers.includes("number") ? safeParseNumber(event.target.value) : event.target.value;
          return event.target.checked ? currentValue.concat([newValue]) : currentValue.filter(el2 => !checkedAttrLooseCompare2(el2, newValue));
        } else {
          return event.target.checked;
        }
      } else if (el.tagName.toLowerCase() === "select" && el.multiple) {
        return modifiers.includes("number") ? Array.from(event.target.selectedOptions).map(option => {
          let rawValue = option.value || option.text;
          return safeParseNumber(rawValue);
        }) : Array.from(event.target.selectedOptions).map(option => {
          return option.value || option.text;
        });
      } else {
        let rawValue = event.target.value;
        return modifiers.includes("number") ? safeParseNumber(rawValue) : modifiers.includes("trim") ? rawValue.trim() : rawValue;
      }
    });
  }
  function safeParseNumber(rawValue) {
    let number = rawValue ? parseFloat(rawValue) : null;
    return isNumeric2(number) ? number : rawValue;
  }
  function checkedAttrLooseCompare2(valueA, valueB) {
    return valueA == valueB;
  }
  function isNumeric2(subject) {
    return !Array.isArray(subject) && !isNaN(subject);
  }
  function isGetterSetter(value) {
    return value !== null && typeof value === "object" && typeof value.get === "function" && typeof value.set === "function";
  }

  // packages/alpinejs/src/directives/x-cloak.js
  directive("cloak", el => queueMicrotask(() => mutateDom(() => el.removeAttribute(prefix("cloak")))));

  // packages/alpinejs/src/directives/x-init.js
  addInitSelector(() => `[${prefix("init")}]`);
  directive("init", skipDuringClone((el, {
    expression
  }, {
    evaluate: evaluate2
  }) => {
    if (typeof expression === "string") {
      return !!expression.trim() && evaluate2(expression, {}, false);
    }
    return evaluate2(expression, {}, false);
  }));

  // packages/alpinejs/src/directives/x-text.js
  directive("text", (el, {
    expression
  }, {
    effect: effect3,
    evaluateLater: evaluateLater2
  }) => {
    let evaluate2 = evaluateLater2(expression);
    effect3(() => {
      evaluate2(value => {
        mutateDom(() => {
          el.textContent = value;
        });
      });
    });
  });

  // packages/alpinejs/src/directives/x-html.js
  directive("html", (el, {
    expression
  }, {
    effect: effect3,
    evaluateLater: evaluateLater2
  }) => {
    let evaluate2 = evaluateLater2(expression);
    effect3(() => {
      evaluate2(value => {
        mutateDom(() => {
          el.innerHTML = value;
          el._x_ignoreSelf = true;
          initTree(el);
          delete el._x_ignoreSelf;
        });
      });
    });
  });

  // packages/alpinejs/src/directives/x-bind.js
  mapAttributes(startingWith(":", into(prefix("bind:"))));
  var handler2 = (el, {
    value,
    modifiers,
    expression,
    original
  }, {
    effect: effect3
  }) => {
    if (!value) {
      let bindingProviders = {};
      injectBindingProviders(bindingProviders);
      let getBindings = evaluateLater(el, expression);
      getBindings(bindings => {
        applyBindingsObject(el, bindings, original);
      }, {
        scope: bindingProviders
      });
      return;
    }
    if (value === "key") return storeKeyForXFor(el, expression);
    if (el._x_inlineBindings && el._x_inlineBindings[value] && el._x_inlineBindings[value].extract) {
      return;
    }
    let evaluate2 = evaluateLater(el, expression);
    effect3(() => evaluate2(result => {
      if (result === void 0 && typeof expression === "string" && expression.match(/\./)) {
        result = "";
      }
      mutateDom(() => bind(el, value, result, modifiers));
    }));
  };
  handler2.inline = (el, {
    value,
    modifiers,
    expression
  }) => {
    if (!value) return;
    if (!el._x_inlineBindings) el._x_inlineBindings = {};
    el._x_inlineBindings[value] = {
      expression,
      extract: false
    };
  };
  directive("bind", handler2);
  function storeKeyForXFor(el, expression) {
    el._x_keyExpression = expression;
  }

  // packages/alpinejs/src/directives/x-data.js
  addRootSelector(() => `[${prefix("data")}]`);
  directive("data", skipDuringClone((el, {
    expression
  }, {
    cleanup: cleanup2
  }) => {
    expression = expression === "" ? "{}" : expression;
    let magicContext = {};
    injectMagics(magicContext, el);
    let dataProviderContext = {};
    injectDataProviders(dataProviderContext, magicContext);
    let data2 = evaluate(el, expression, {
      scope: dataProviderContext
    });
    if (data2 === void 0 || data2 === true) data2 = {};
    injectMagics(data2, el);
    let reactiveData = reactive(data2);
    initInterceptors(reactiveData);
    let undo = addScopeToNode(el, reactiveData);
    reactiveData["init"] && evaluate(el, reactiveData["init"]);
    cleanup2(() => {
      reactiveData["destroy"] && evaluate(el, reactiveData["destroy"]);
      undo();
    });
  }));

  // packages/alpinejs/src/directives/x-show.js
  directive("show", (el, {
    modifiers,
    expression
  }, {
    effect: effect3
  }) => {
    let evaluate2 = evaluateLater(el, expression);
    if (!el._x_doHide) el._x_doHide = () => {
      mutateDom(() => {
        el.style.setProperty("display", "none", modifiers.includes("important") ? "important" : void 0);
      });
    };
    if (!el._x_doShow) el._x_doShow = () => {
      mutateDom(() => {
        if (el.style.length === 1 && el.style.display === "none") {
          el.removeAttribute("style");
        } else {
          el.style.removeProperty("display");
        }
      });
    };
    let hide = () => {
      el._x_doHide();
      el._x_isShown = false;
    };
    let show = () => {
      el._x_doShow();
      el._x_isShown = true;
    };
    let clickAwayCompatibleShow = () => setTimeout(show);
    let toggle = once(value => value ? show() : hide(), value => {
      if (typeof el._x_toggleAndCascadeWithTransitions === "function") {
        el._x_toggleAndCascadeWithTransitions(el, value, show, hide);
      } else {
        value ? clickAwayCompatibleShow() : hide();
      }
    });
    let oldValue;
    let firstTime = true;
    effect3(() => evaluate2(value => {
      if (!firstTime && value === oldValue) return;
      if (modifiers.includes("immediate")) value ? clickAwayCompatibleShow() : hide();
      toggle(value);
      oldValue = value;
      firstTime = false;
    }));
  });

  // packages/alpinejs/src/directives/x-for.js
  directive("for", (el, {
    expression
  }, {
    effect: effect3,
    cleanup: cleanup2
  }) => {
    let iteratorNames = parseForExpression(expression);
    let evaluateItems = evaluateLater(el, iteratorNames.items);
    let evaluateKey = evaluateLater(el, el._x_keyExpression || "index");
    el._x_prevKeys = [];
    el._x_lookup = {};
    effect3(() => loop(el, iteratorNames, evaluateItems, evaluateKey));
    cleanup2(() => {
      Object.values(el._x_lookup).forEach(el2 => el2.remove());
      delete el._x_prevKeys;
      delete el._x_lookup;
    });
  });
  function loop(el, iteratorNames, evaluateItems, evaluateKey) {
    let isObject2 = i => typeof i === "object" && !Array.isArray(i);
    let templateEl = el;
    evaluateItems(items => {
      if (isNumeric3(items) && items >= 0) {
        items = Array.from(Array(items).keys(), i => i + 1);
      }
      if (items === void 0) items = [];
      let lookup = el._x_lookup;
      let prevKeys = el._x_prevKeys;
      let scopes = [];
      let keys = [];
      if (isObject2(items)) {
        items = Object.entries(items).map(([key, value]) => {
          let scope2 = getIterationScopeVariables(iteratorNames, value, key, items);
          evaluateKey(value2 => keys.push(value2), {
            scope: {
              index: key,
              ...scope2
            }
          });
          scopes.push(scope2);
        });
      } else {
        for (let i = 0; i < items.length; i++) {
          let scope2 = getIterationScopeVariables(iteratorNames, items[i], i, items);
          evaluateKey(value => keys.push(value), {
            scope: {
              index: i,
              ...scope2
            }
          });
          scopes.push(scope2);
        }
      }
      let adds = [];
      let moves = [];
      let removes = [];
      let sames = [];
      for (let i = 0; i < prevKeys.length; i++) {
        let key = prevKeys[i];
        if (keys.indexOf(key) === -1) removes.push(key);
      }
      prevKeys = prevKeys.filter(key => !removes.includes(key));
      let lastKey = "template";
      for (let i = 0; i < keys.length; i++) {
        let key = keys[i];
        let prevIndex = prevKeys.indexOf(key);
        if (prevIndex === -1) {
          prevKeys.splice(i, 0, key);
          adds.push([lastKey, i]);
        } else if (prevIndex !== i) {
          let keyInSpot = prevKeys.splice(i, 1)[0];
          let keyForSpot = prevKeys.splice(prevIndex - 1, 1)[0];
          prevKeys.splice(i, 0, keyForSpot);
          prevKeys.splice(prevIndex, 0, keyInSpot);
          moves.push([keyInSpot, keyForSpot]);
        } else {
          sames.push(key);
        }
        lastKey = key;
      }
      for (let i = 0; i < removes.length; i++) {
        let key = removes[i];
        if (!!lookup[key]._x_effects) {
          lookup[key]._x_effects.forEach(dequeueJob);
        }
        lookup[key].remove();
        lookup[key] = null;
        delete lookup[key];
      }
      for (let i = 0; i < moves.length; i++) {
        let [keyInSpot, keyForSpot] = moves[i];
        let elInSpot = lookup[keyInSpot];
        let elForSpot = lookup[keyForSpot];
        let marker = document.createElement("div");
        mutateDom(() => {
          if (!elForSpot) warn(`x-for ":key" is undefined or invalid`, templateEl);
          elForSpot.after(marker);
          elInSpot.after(elForSpot);
          elForSpot._x_currentIfEl && elForSpot.after(elForSpot._x_currentIfEl);
          marker.before(elInSpot);
          elInSpot._x_currentIfEl && elInSpot.after(elInSpot._x_currentIfEl);
          marker.remove();
        });
        elForSpot._x_refreshXForScope(scopes[keys.indexOf(keyForSpot)]);
      }
      for (let i = 0; i < adds.length; i++) {
        let [lastKey2, index] = adds[i];
        let lastEl = lastKey2 === "template" ? templateEl : lookup[lastKey2];
        if (lastEl._x_currentIfEl) lastEl = lastEl._x_currentIfEl;
        let scope2 = scopes[index];
        let key = keys[index];
        let clone2 = document.importNode(templateEl.content, true).firstElementChild;
        let reactiveScope = reactive(scope2);
        addScopeToNode(clone2, reactiveScope, templateEl);
        clone2._x_refreshXForScope = newScope => {
          Object.entries(newScope).forEach(([key2, value]) => {
            reactiveScope[key2] = value;
          });
        };
        mutateDom(() => {
          lastEl.after(clone2);
          initTree(clone2);
        });
        if (typeof key === "object") {
          warn("x-for key cannot be an object, it must be a string or an integer", templateEl);
        }
        lookup[key] = clone2;
      }
      for (let i = 0; i < sames.length; i++) {
        lookup[sames[i]]._x_refreshXForScope(scopes[keys.indexOf(sames[i])]);
      }
      templateEl._x_prevKeys = keys;
    });
  }
  function parseForExpression(expression) {
    let forIteratorRE = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/;
    let stripParensRE = /^\s*\(|\)\s*$/g;
    let forAliasRE = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/;
    let inMatch = expression.match(forAliasRE);
    if (!inMatch) return;
    let res = {};
    res.items = inMatch[2].trim();
    let item = inMatch[1].replace(stripParensRE, "").trim();
    let iteratorMatch = item.match(forIteratorRE);
    if (iteratorMatch) {
      res.item = item.replace(forIteratorRE, "").trim();
      res.index = iteratorMatch[1].trim();
      if (iteratorMatch[2]) {
        res.collection = iteratorMatch[2].trim();
      }
    } else {
      res.item = item;
    }
    return res;
  }
  function getIterationScopeVariables(iteratorNames, item, index, items) {
    let scopeVariables = {};
    if (/^\[.*\]$/.test(iteratorNames.item) && Array.isArray(item)) {
      let names = iteratorNames.item.replace("[", "").replace("]", "").split(",").map(i => i.trim());
      names.forEach((name, i) => {
        scopeVariables[name] = item[i];
      });
    } else if (/^\{.*\}$/.test(iteratorNames.item) && !Array.isArray(item) && typeof item === "object") {
      let names = iteratorNames.item.replace("{", "").replace("}", "").split(",").map(i => i.trim());
      names.forEach(name => {
        scopeVariables[name] = item[name];
      });
    } else {
      scopeVariables[iteratorNames.item] = item;
    }
    if (iteratorNames.index) scopeVariables[iteratorNames.index] = index;
    if (iteratorNames.collection) scopeVariables[iteratorNames.collection] = items;
    return scopeVariables;
  }
  function isNumeric3(subject) {
    return !Array.isArray(subject) && !isNaN(subject);
  }

  // packages/alpinejs/src/directives/x-ref.js
  function handler3() {}
  handler3.inline = (el, {
    expression
  }, {
    cleanup: cleanup2
  }) => {
    let root = closestRoot(el);
    if (!root._x_refs) root._x_refs = {};
    root._x_refs[expression] = el;
    cleanup2(() => delete root._x_refs[expression]);
  };
  directive("ref", handler3);

  // packages/alpinejs/src/directives/x-if.js
  directive("if", (el, {
    expression
  }, {
    effect: effect3,
    cleanup: cleanup2
  }) => {
    let evaluate2 = evaluateLater(el, expression);
    let show = () => {
      if (el._x_currentIfEl) return el._x_currentIfEl;
      let clone2 = el.content.cloneNode(true).firstElementChild;
      addScopeToNode(clone2, {}, el);
      mutateDom(() => {
        el.after(clone2);
        initTree(clone2);
      });
      el._x_currentIfEl = clone2;
      el._x_undoIf = () => {
        walk(clone2, node => {
          if (!!node._x_effects) {
            node._x_effects.forEach(dequeueJob);
          }
        });
        clone2.remove();
        delete el._x_currentIfEl;
      };
      return clone2;
    };
    let hide = () => {
      if (!el._x_undoIf) return;
      el._x_undoIf();
      delete el._x_undoIf;
    };
    effect3(() => evaluate2(value => {
      value ? show() : hide();
    }));
    cleanup2(() => el._x_undoIf && el._x_undoIf());
  });

  // packages/alpinejs/src/directives/x-id.js
  directive("id", (el, {
    expression
  }, {
    evaluate: evaluate2
  }) => {
    let names = evaluate2(expression);
    names.forEach(name => setIdRoot(el, name));
  });

  // packages/alpinejs/src/directives/x-on.js
  mapAttributes(startingWith("@", into(prefix("on:"))));
  directive("on", skipDuringClone((el, {
    value,
    modifiers,
    expression
  }, {
    cleanup: cleanup2
  }) => {
    let evaluate2 = expression ? evaluateLater(el, expression) : () => {};
    if (el.tagName.toLowerCase() === "template") {
      if (!el._x_forwardEvents) el._x_forwardEvents = [];
      if (!el._x_forwardEvents.includes(value)) el._x_forwardEvents.push(value);
    }
    let removeListener = on(el, value, modifiers, e => {
      evaluate2(() => {}, {
        scope: {
          $event: e
        },
        params: [e]
      });
    });
    cleanup2(() => removeListener());
  }));

  // packages/alpinejs/src/directives/index.js
  warnMissingPluginDirective("Collapse", "collapse", "collapse");
  warnMissingPluginDirective("Intersect", "intersect", "intersect");
  warnMissingPluginDirective("Focus", "trap", "focus");
  warnMissingPluginDirective("Mask", "mask", "mask");
  function warnMissingPluginDirective(name, directiveName2, slug) {
    directive(directiveName2, el => warn(`You can't use [x-${directiveName2}] without first installing the "${name}" plugin here: https://alpinejs.dev/plugins/${slug}`, el));
  }

  // packages/alpinejs/src/index.js
  alpine_default.setEvaluator(normalEvaluator);
  alpine_default.setReactivityEngine({
    reactive: reactive2,
    effect: effect2,
    release: stop,
    raw: toRaw
  });
  var src_default$2 = alpine_default;

  // packages/alpinejs/builds/module.js
  var module_default$2 = src_default$2;

  // packages/mask/src/index.js
  function src_default$1(Alpine) {
    Alpine.directive("mask", (el, {
      value,
      expression
    }, {
      effect,
      evaluateLater
    }) => {
      let templateFn = () => expression;
      let lastInputValue = "";
      queueMicrotask(() => {
        if (["function", "dynamic"].includes(value)) {
          let evaluator = evaluateLater(expression);
          effect(() => {
            templateFn = input => {
              let result;
              Alpine.dontAutoEvaluateFunctions(() => {
                evaluator(value2 => {
                  result = typeof value2 === "function" ? value2(input) : value2;
                }, {
                  scope: {
                    $input: input,
                    $money: formatMoney.bind({
                      el
                    })
                  }
                });
              });
              return result;
            };
            processInputValue(el, false);
          });
        } else {
          processInputValue(el, false);
        }
        if (el._x_model) el._x_model.set(el.value);
      });
      el.addEventListener("input", () => processInputValue(el));
      el.addEventListener("blur", () => processInputValue(el, false));
      function processInputValue(el2, shouldRestoreCursor = true) {
        let input = el2.value;
        let template = templateFn(input);
        if (!template || template === "false") return false;
        if (lastInputValue.length - el2.value.length === 1) {
          return lastInputValue = el2.value;
        }
        let setInput = () => {
          lastInputValue = el2.value = formatInput(input, template);
        };
        if (shouldRestoreCursor) {
          restoreCursorPosition(el2, template, () => {
            setInput();
          });
        } else {
          setInput();
        }
      }
      function formatInput(input, template) {
        if (input === "") return "";
        let strippedDownInput = stripDown(template, input);
        let rebuiltInput = buildUp(template, strippedDownInput);
        return rebuiltInput;
      }
    }).before("model");
  }
  function restoreCursorPosition(el, template, callback) {
    let cursorPosition = el.selectionStart;
    let unformattedValue = el.value;
    callback();
    let beforeLeftOfCursorBeforeFormatting = unformattedValue.slice(0, cursorPosition);
    let newPosition = buildUp(template, stripDown(template, beforeLeftOfCursorBeforeFormatting)).length;
    el.setSelectionRange(newPosition, newPosition);
  }
  function stripDown(template, input) {
    let inputToBeStripped = input;
    let output = "";
    let regexes = {
      "9": /[0-9]/,
      a: /[a-zA-Z]/,
      "*": /[a-zA-Z0-9]/
    };
    let wildcardTemplate = "";
    for (let i = 0; i < template.length; i++) {
      if (["9", "a", "*"].includes(template[i])) {
        wildcardTemplate += template[i];
        continue;
      }
      for (let j = 0; j < inputToBeStripped.length; j++) {
        if (inputToBeStripped[j] === template[i]) {
          inputToBeStripped = inputToBeStripped.slice(0, j) + inputToBeStripped.slice(j + 1);
          break;
        }
      }
    }
    for (let i = 0; i < wildcardTemplate.length; i++) {
      let found = false;
      for (let j = 0; j < inputToBeStripped.length; j++) {
        if (regexes[wildcardTemplate[i]].test(inputToBeStripped[j])) {
          output += inputToBeStripped[j];
          inputToBeStripped = inputToBeStripped.slice(0, j) + inputToBeStripped.slice(j + 1);
          found = true;
          break;
        }
      }
      if (!found) break;
    }
    return output;
  }
  function buildUp(template, input) {
    let clean = Array.from(input);
    let output = "";
    for (let i = 0; i < template.length; i++) {
      if (!["9", "a", "*"].includes(template[i])) {
        output += template[i];
        continue;
      }
      if (clean.length === 0) break;
      output += clean.shift();
    }
    return output;
  }
  function formatMoney(input, delimiter = ".", thousands, precision = 2) {
    if (input === "-") return "-";
    if (/^\D+$/.test(input)) return "9";
    thousands = thousands ?? (delimiter === "," ? "." : ",");
    let addThousands = (input2, thousands2) => {
      let output = "";
      let counter = 0;
      for (let i = input2.length - 1; i >= 0; i--) {
        if (input2[i] === thousands2) continue;
        if (counter === 3) {
          output = input2[i] + thousands2 + output;
          counter = 0;
        } else {
          output = input2[i] + output;
        }
        counter++;
      }
      return output;
    };
    let minus = input.startsWith("-") ? "-" : "";
    let strippedInput = input.replaceAll(new RegExp(`[^0-9\\${delimiter}]`, "g"), "");
    let template = Array.from({
      length: strippedInput.split(delimiter)[0].length
    }).fill("9").join("");
    template = `${minus}${addThousands(template, thousands)}`;
    if (precision > 0 && input.includes(delimiter)) template += `${delimiter}` + "9".repeat(precision);
    queueMicrotask(() => {
      if (this.el.value.endsWith(delimiter)) return;
      if (this.el.value[this.el.selectionStart - 1] === delimiter) {
        this.el.setSelectionRange(this.el.selectionStart - 1, this.el.selectionStart - 1);
      }
    });
    return template;
  }

  // packages/mask/builds/module.js
  var module_default$1 = src_default$1;

  var __create = Object.create;
  var __defProp = Object.defineProperty;
  var __getProtoOf = Object.getPrototypeOf;
  var __hasOwnProp = Object.prototype.hasOwnProperty;
  var __getOwnPropNames = Object.getOwnPropertyNames;
  var __getOwnPropDesc = Object.getOwnPropertyDescriptor;
  var __markAsModule = target => __defProp(target, "__esModule", {
    value: true
  });
  var __commonJS = (callback, module) => () => {
    if (!module) {
      module = {
        exports: {}
      };
      callback(module.exports, module);
    }
    return module.exports;
  };
  var __exportStar = (target, module, desc) => {
    if (module && typeof module === "object" || typeof module === "function") {
      for (let key of __getOwnPropNames(module)) if (!__hasOwnProp.call(target, key) && key !== "default") __defProp(target, key, {
        get: () => module[key],
        enumerable: !(desc = __getOwnPropDesc(module, key)) || desc.enumerable
      });
    }
    return target;
  };
  var __toModule = module => {
    return __exportStar(__markAsModule(__defProp(module != null ? __create(__getProtoOf(module)) : {}, "default", module && module.__esModule && "default" in module ? {
      get: () => module.default,
      enumerable: true
    } : {
      value: module,
      enumerable: true
    })), module);
  };

  // node_modules/@popperjs/core/dist/cjs/popper.js
  var require_popper = __commonJS(exports => {

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    function getBoundingClientRect(element) {
      var rect = element.getBoundingClientRect();
      return {
        width: rect.width,
        height: rect.height,
        top: rect.top,
        right: rect.right,
        bottom: rect.bottom,
        left: rect.left,
        x: rect.left,
        y: rect.top
      };
    }
    function getWindow(node) {
      if (node == null) {
        return window;
      }
      if (node.toString() !== "[object Window]") {
        var ownerDocument = node.ownerDocument;
        return ownerDocument ? ownerDocument.defaultView || window : window;
      }
      return node;
    }
    function getWindowScroll(node) {
      var win = getWindow(node);
      var scrollLeft = win.pageXOffset;
      var scrollTop = win.pageYOffset;
      return {
        scrollLeft,
        scrollTop
      };
    }
    function isElement(node) {
      var OwnElement = getWindow(node).Element;
      return node instanceof OwnElement || node instanceof Element;
    }
    function isHTMLElement(node) {
      var OwnElement = getWindow(node).HTMLElement;
      return node instanceof OwnElement || node instanceof HTMLElement;
    }
    function isShadowRoot(node) {
      if (typeof ShadowRoot === "undefined") {
        return false;
      }
      var OwnElement = getWindow(node).ShadowRoot;
      return node instanceof OwnElement || node instanceof ShadowRoot;
    }
    function getHTMLElementScroll(element) {
      return {
        scrollLeft: element.scrollLeft,
        scrollTop: element.scrollTop
      };
    }
    function getNodeScroll(node) {
      if (node === getWindow(node) || !isHTMLElement(node)) {
        return getWindowScroll(node);
      } else {
        return getHTMLElementScroll(node);
      }
    }
    function getNodeName(element) {
      return element ? (element.nodeName || "").toLowerCase() : null;
    }
    function getDocumentElement(element) {
      return ((isElement(element) ? element.ownerDocument : element.document) || window.document).documentElement;
    }
    function getWindowScrollBarX(element) {
      return getBoundingClientRect(getDocumentElement(element)).left + getWindowScroll(element).scrollLeft;
    }
    function getComputedStyle(element) {
      return getWindow(element).getComputedStyle(element);
    }
    function isScrollParent(element) {
      var _getComputedStyle = getComputedStyle(element),
        overflow = _getComputedStyle.overflow,
        overflowX = _getComputedStyle.overflowX,
        overflowY = _getComputedStyle.overflowY;
      return /auto|scroll|overlay|hidden/.test(overflow + overflowY + overflowX);
    }
    function getCompositeRect(elementOrVirtualElement, offsetParent, isFixed) {
      if (isFixed === void 0) {
        isFixed = false;
      }
      var documentElement = getDocumentElement(offsetParent);
      var rect = getBoundingClientRect(elementOrVirtualElement);
      var isOffsetParentAnElement = isHTMLElement(offsetParent);
      var scroll = {
        scrollLeft: 0,
        scrollTop: 0
      };
      var offsets = {
        x: 0,
        y: 0
      };
      if (isOffsetParentAnElement || !isOffsetParentAnElement && !isFixed) {
        if (getNodeName(offsetParent) !== "body" || isScrollParent(documentElement)) {
          scroll = getNodeScroll(offsetParent);
        }
        if (isHTMLElement(offsetParent)) {
          offsets = getBoundingClientRect(offsetParent);
          offsets.x += offsetParent.clientLeft;
          offsets.y += offsetParent.clientTop;
        } else if (documentElement) {
          offsets.x = getWindowScrollBarX(documentElement);
        }
      }
      return {
        x: rect.left + scroll.scrollLeft - offsets.x,
        y: rect.top + scroll.scrollTop - offsets.y,
        width: rect.width,
        height: rect.height
      };
    }
    function getLayoutRect(element) {
      var clientRect = getBoundingClientRect(element);
      var width = element.offsetWidth;
      var height = element.offsetHeight;
      if (Math.abs(clientRect.width - width) <= 1) {
        width = clientRect.width;
      }
      if (Math.abs(clientRect.height - height) <= 1) {
        height = clientRect.height;
      }
      return {
        x: element.offsetLeft,
        y: element.offsetTop,
        width,
        height
      };
    }
    function getParentNode(element) {
      if (getNodeName(element) === "html") {
        return element;
      }
      return element.assignedSlot || element.parentNode || (isShadowRoot(element) ? element.host : null) || getDocumentElement(element);
    }
    function getScrollParent(node) {
      if (["html", "body", "#document"].indexOf(getNodeName(node)) >= 0) {
        return node.ownerDocument.body;
      }
      if (isHTMLElement(node) && isScrollParent(node)) {
        return node;
      }
      return getScrollParent(getParentNode(node));
    }
    function listScrollParents(element, list) {
      var _element$ownerDocumen;
      if (list === void 0) {
        list = [];
      }
      var scrollParent = getScrollParent(element);
      var isBody = scrollParent === ((_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body);
      var win = getWindow(scrollParent);
      var target = isBody ? [win].concat(win.visualViewport || [], isScrollParent(scrollParent) ? scrollParent : []) : scrollParent;
      var updatedList = list.concat(target);
      return isBody ? updatedList : updatedList.concat(listScrollParents(getParentNode(target)));
    }
    function isTableElement(element) {
      return ["table", "td", "th"].indexOf(getNodeName(element)) >= 0;
    }
    function getTrueOffsetParent(element) {
      if (!isHTMLElement(element) || getComputedStyle(element).position === "fixed") {
        return null;
      }
      return element.offsetParent;
    }
    function getContainingBlock(element) {
      var isFirefox = navigator.userAgent.toLowerCase().indexOf("firefox") !== -1;
      var isIE = navigator.userAgent.indexOf("Trident") !== -1;
      if (isIE && isHTMLElement(element)) {
        var elementCss = getComputedStyle(element);
        if (elementCss.position === "fixed") {
          return null;
        }
      }
      var currentNode = getParentNode(element);
      while (isHTMLElement(currentNode) && ["html", "body"].indexOf(getNodeName(currentNode)) < 0) {
        var css = getComputedStyle(currentNode);
        if (css.transform !== "none" || css.perspective !== "none" || css.contain === "paint" || ["transform", "perspective"].indexOf(css.willChange) !== -1 || isFirefox && css.willChange === "filter" || isFirefox && css.filter && css.filter !== "none") {
          return currentNode;
        } else {
          currentNode = currentNode.parentNode;
        }
      }
      return null;
    }
    function getOffsetParent(element) {
      var window2 = getWindow(element);
      var offsetParent = getTrueOffsetParent(element);
      while (offsetParent && isTableElement(offsetParent) && getComputedStyle(offsetParent).position === "static") {
        offsetParent = getTrueOffsetParent(offsetParent);
      }
      if (offsetParent && (getNodeName(offsetParent) === "html" || getNodeName(offsetParent) === "body" && getComputedStyle(offsetParent).position === "static")) {
        return window2;
      }
      return offsetParent || getContainingBlock(element) || window2;
    }
    var top = "top";
    var bottom = "bottom";
    var right = "right";
    var left = "left";
    var auto = "auto";
    var basePlacements = [top, bottom, right, left];
    var start = "start";
    var end = "end";
    var clippingParents = "clippingParents";
    var viewport = "viewport";
    var popper = "popper";
    var reference = "reference";
    var variationPlacements = /* @__PURE__ */basePlacements.reduce(function (acc, placement) {
      return acc.concat([placement + "-" + start, placement + "-" + end]);
    }, []);
    var placements = /* @__PURE__ */[].concat(basePlacements, [auto]).reduce(function (acc, placement) {
      return acc.concat([placement, placement + "-" + start, placement + "-" + end]);
    }, []);
    var beforeRead = "beforeRead";
    var read = "read";
    var afterRead = "afterRead";
    var beforeMain = "beforeMain";
    var main = "main";
    var afterMain = "afterMain";
    var beforeWrite = "beforeWrite";
    var write = "write";
    var afterWrite = "afterWrite";
    var modifierPhases = [beforeRead, read, afterRead, beforeMain, main, afterMain, beforeWrite, write, afterWrite];
    function order(modifiers) {
      var map = new Map();
      var visited = new Set();
      var result = [];
      modifiers.forEach(function (modifier) {
        map.set(modifier.name, modifier);
      });
      function sort(modifier) {
        visited.add(modifier.name);
        var requires = [].concat(modifier.requires || [], modifier.requiresIfExists || []);
        requires.forEach(function (dep) {
          if (!visited.has(dep)) {
            var depModifier = map.get(dep);
            if (depModifier) {
              sort(depModifier);
            }
          }
        });
        result.push(modifier);
      }
      modifiers.forEach(function (modifier) {
        if (!visited.has(modifier.name)) {
          sort(modifier);
        }
      });
      return result;
    }
    function orderModifiers(modifiers) {
      var orderedModifiers = order(modifiers);
      return modifierPhases.reduce(function (acc, phase) {
        return acc.concat(orderedModifiers.filter(function (modifier) {
          return modifier.phase === phase;
        }));
      }, []);
    }
    function debounce(fn) {
      var pending;
      return function () {
        if (!pending) {
          pending = new Promise(function (resolve) {
            Promise.resolve().then(function () {
              pending = void 0;
              resolve(fn());
            });
          });
        }
        return pending;
      };
    }
    function format(str) {
      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
        args[_key - 1] = arguments[_key];
      }
      return [].concat(args).reduce(function (p, c) {
        return p.replace(/%s/, c);
      }, str);
    }
    var INVALID_MODIFIER_ERROR = 'Popper: modifier "%s" provided an invalid %s property, expected %s but got %s';
    var MISSING_DEPENDENCY_ERROR = 'Popper: modifier "%s" requires "%s", but "%s" modifier is not available';
    var VALID_PROPERTIES = ["name", "enabled", "phase", "fn", "effect", "requires", "options"];
    function validateModifiers(modifiers) {
      modifiers.forEach(function (modifier) {
        Object.keys(modifier).forEach(function (key) {
          switch (key) {
            case "name":
              if (typeof modifier.name !== "string") {
                console.error(format(INVALID_MODIFIER_ERROR, String(modifier.name), '"name"', '"string"', '"' + String(modifier.name) + '"'));
              }
              break;
            case "enabled":
              if (typeof modifier.enabled !== "boolean") {
                console.error(format(INVALID_MODIFIER_ERROR, modifier.name, '"enabled"', '"boolean"', '"' + String(modifier.enabled) + '"'));
              }
            case "phase":
              if (modifierPhases.indexOf(modifier.phase) < 0) {
                console.error(format(INVALID_MODIFIER_ERROR, modifier.name, '"phase"', "either " + modifierPhases.join(", "), '"' + String(modifier.phase) + '"'));
              }
              break;
            case "fn":
              if (typeof modifier.fn !== "function") {
                console.error(format(INVALID_MODIFIER_ERROR, modifier.name, '"fn"', '"function"', '"' + String(modifier.fn) + '"'));
              }
              break;
            case "effect":
              if (typeof modifier.effect !== "function") {
                console.error(format(INVALID_MODIFIER_ERROR, modifier.name, '"effect"', '"function"', '"' + String(modifier.fn) + '"'));
              }
              break;
            case "requires":
              if (!Array.isArray(modifier.requires)) {
                console.error(format(INVALID_MODIFIER_ERROR, modifier.name, '"requires"', '"array"', '"' + String(modifier.requires) + '"'));
              }
              break;
            case "requiresIfExists":
              if (!Array.isArray(modifier.requiresIfExists)) {
                console.error(format(INVALID_MODIFIER_ERROR, modifier.name, '"requiresIfExists"', '"array"', '"' + String(modifier.requiresIfExists) + '"'));
              }
              break;
            case "options":
            case "data":
              break;
            default:
              console.error('PopperJS: an invalid property has been provided to the "' + modifier.name + '" modifier, valid properties are ' + VALID_PROPERTIES.map(function (s) {
                return '"' + s + '"';
              }).join(", ") + '; but "' + key + '" was provided.');
          }
          modifier.requires && modifier.requires.forEach(function (requirement) {
            if (modifiers.find(function (mod) {
              return mod.name === requirement;
            }) == null) {
              console.error(format(MISSING_DEPENDENCY_ERROR, String(modifier.name), requirement, requirement));
            }
          });
        });
      });
    }
    function uniqueBy(arr, fn) {
      var identifiers = new Set();
      return arr.filter(function (item) {
        var identifier = fn(item);
        if (!identifiers.has(identifier)) {
          identifiers.add(identifier);
          return true;
        }
      });
    }
    function getBasePlacement(placement) {
      return placement.split("-")[0];
    }
    function mergeByName(modifiers) {
      var merged = modifiers.reduce(function (merged2, current) {
        var existing = merged2[current.name];
        merged2[current.name] = existing ? Object.assign({}, existing, current, {
          options: Object.assign({}, existing.options, current.options),
          data: Object.assign({}, existing.data, current.data)
        }) : current;
        return merged2;
      }, {});
      return Object.keys(merged).map(function (key) {
        return merged[key];
      });
    }
    function getViewportRect(element) {
      var win = getWindow(element);
      var html = getDocumentElement(element);
      var visualViewport = win.visualViewport;
      var width = html.clientWidth;
      var height = html.clientHeight;
      var x = 0;
      var y = 0;
      if (visualViewport) {
        width = visualViewport.width;
        height = visualViewport.height;
        if (!/^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
          x = visualViewport.offsetLeft;
          y = visualViewport.offsetTop;
        }
      }
      return {
        width,
        height,
        x: x + getWindowScrollBarX(element),
        y
      };
    }
    var max = Math.max;
    var min = Math.min;
    var round = Math.round;
    function getDocumentRect(element) {
      var _element$ownerDocumen;
      var html = getDocumentElement(element);
      var winScroll = getWindowScroll(element);
      var body = (_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body;
      var width = max(html.scrollWidth, html.clientWidth, body ? body.scrollWidth : 0, body ? body.clientWidth : 0);
      var height = max(html.scrollHeight, html.clientHeight, body ? body.scrollHeight : 0, body ? body.clientHeight : 0);
      var x = -winScroll.scrollLeft + getWindowScrollBarX(element);
      var y = -winScroll.scrollTop;
      if (getComputedStyle(body || html).direction === "rtl") {
        x += max(html.clientWidth, body ? body.clientWidth : 0) - width;
      }
      return {
        width,
        height,
        x,
        y
      };
    }
    function contains(parent, child) {
      var rootNode = child.getRootNode && child.getRootNode();
      if (parent.contains(child)) {
        return true;
      } else if (rootNode && isShadowRoot(rootNode)) {
        var next = child;
        do {
          if (next && parent.isSameNode(next)) {
            return true;
          }
          next = next.parentNode || next.host;
        } while (next);
      }
      return false;
    }
    function rectToClientRect(rect) {
      return Object.assign({}, rect, {
        left: rect.x,
        top: rect.y,
        right: rect.x + rect.width,
        bottom: rect.y + rect.height
      });
    }
    function getInnerBoundingClientRect(element) {
      var rect = getBoundingClientRect(element);
      rect.top = rect.top + element.clientTop;
      rect.left = rect.left + element.clientLeft;
      rect.bottom = rect.top + element.clientHeight;
      rect.right = rect.left + element.clientWidth;
      rect.width = element.clientWidth;
      rect.height = element.clientHeight;
      rect.x = rect.left;
      rect.y = rect.top;
      return rect;
    }
    function getClientRectFromMixedType(element, clippingParent) {
      return clippingParent === viewport ? rectToClientRect(getViewportRect(element)) : isHTMLElement(clippingParent) ? getInnerBoundingClientRect(clippingParent) : rectToClientRect(getDocumentRect(getDocumentElement(element)));
    }
    function getClippingParents(element) {
      var clippingParents2 = listScrollParents(getParentNode(element));
      var canEscapeClipping = ["absolute", "fixed"].indexOf(getComputedStyle(element).position) >= 0;
      var clipperElement = canEscapeClipping && isHTMLElement(element) ? getOffsetParent(element) : element;
      if (!isElement(clipperElement)) {
        return [];
      }
      return clippingParents2.filter(function (clippingParent) {
        return isElement(clippingParent) && contains(clippingParent, clipperElement) && getNodeName(clippingParent) !== "body";
      });
    }
    function getClippingRect(element, boundary, rootBoundary) {
      var mainClippingParents = boundary === "clippingParents" ? getClippingParents(element) : [].concat(boundary);
      var clippingParents2 = [].concat(mainClippingParents, [rootBoundary]);
      var firstClippingParent = clippingParents2[0];
      var clippingRect = clippingParents2.reduce(function (accRect, clippingParent) {
        var rect = getClientRectFromMixedType(element, clippingParent);
        accRect.top = max(rect.top, accRect.top);
        accRect.right = min(rect.right, accRect.right);
        accRect.bottom = min(rect.bottom, accRect.bottom);
        accRect.left = max(rect.left, accRect.left);
        return accRect;
      }, getClientRectFromMixedType(element, firstClippingParent));
      clippingRect.width = clippingRect.right - clippingRect.left;
      clippingRect.height = clippingRect.bottom - clippingRect.top;
      clippingRect.x = clippingRect.left;
      clippingRect.y = clippingRect.top;
      return clippingRect;
    }
    function getVariation(placement) {
      return placement.split("-")[1];
    }
    function getMainAxisFromPlacement(placement) {
      return ["top", "bottom"].indexOf(placement) >= 0 ? "x" : "y";
    }
    function computeOffsets(_ref) {
      var reference2 = _ref.reference,
        element = _ref.element,
        placement = _ref.placement;
      var basePlacement = placement ? getBasePlacement(placement) : null;
      var variation = placement ? getVariation(placement) : null;
      var commonX = reference2.x + reference2.width / 2 - element.width / 2;
      var commonY = reference2.y + reference2.height / 2 - element.height / 2;
      var offsets;
      switch (basePlacement) {
        case top:
          offsets = {
            x: commonX,
            y: reference2.y - element.height
          };
          break;
        case bottom:
          offsets = {
            x: commonX,
            y: reference2.y + reference2.height
          };
          break;
        case right:
          offsets = {
            x: reference2.x + reference2.width,
            y: commonY
          };
          break;
        case left:
          offsets = {
            x: reference2.x - element.width,
            y: commonY
          };
          break;
        default:
          offsets = {
            x: reference2.x,
            y: reference2.y
          };
      }
      var mainAxis = basePlacement ? getMainAxisFromPlacement(basePlacement) : null;
      if (mainAxis != null) {
        var len = mainAxis === "y" ? "height" : "width";
        switch (variation) {
          case start:
            offsets[mainAxis] = offsets[mainAxis] - (reference2[len] / 2 - element[len] / 2);
            break;
          case end:
            offsets[mainAxis] = offsets[mainAxis] + (reference2[len] / 2 - element[len] / 2);
            break;
        }
      }
      return offsets;
    }
    function getFreshSideObject() {
      return {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
      };
    }
    function mergePaddingObject(paddingObject) {
      return Object.assign({}, getFreshSideObject(), paddingObject);
    }
    function expandToHashMap(value, keys) {
      return keys.reduce(function (hashMap, key) {
        hashMap[key] = value;
        return hashMap;
      }, {});
    }
    function detectOverflow(state, options) {
      if (options === void 0) {
        options = {};
      }
      var _options = options,
        _options$placement = _options.placement,
        placement = _options$placement === void 0 ? state.placement : _options$placement,
        _options$boundary = _options.boundary,
        boundary = _options$boundary === void 0 ? clippingParents : _options$boundary,
        _options$rootBoundary = _options.rootBoundary,
        rootBoundary = _options$rootBoundary === void 0 ? viewport : _options$rootBoundary,
        _options$elementConte = _options.elementContext,
        elementContext = _options$elementConte === void 0 ? popper : _options$elementConte,
        _options$altBoundary = _options.altBoundary,
        altBoundary = _options$altBoundary === void 0 ? false : _options$altBoundary,
        _options$padding = _options.padding,
        padding = _options$padding === void 0 ? 0 : _options$padding;
      var paddingObject = mergePaddingObject(typeof padding !== "number" ? padding : expandToHashMap(padding, basePlacements));
      var altContext = elementContext === popper ? reference : popper;
      var referenceElement = state.elements.reference;
      var popperRect = state.rects.popper;
      var element = state.elements[altBoundary ? altContext : elementContext];
      var clippingClientRect = getClippingRect(isElement(element) ? element : element.contextElement || getDocumentElement(state.elements.popper), boundary, rootBoundary);
      var referenceClientRect = getBoundingClientRect(referenceElement);
      var popperOffsets2 = computeOffsets({
        reference: referenceClientRect,
        element: popperRect,
        strategy: "absolute",
        placement
      });
      var popperClientRect = rectToClientRect(Object.assign({}, popperRect, popperOffsets2));
      var elementClientRect = elementContext === popper ? popperClientRect : referenceClientRect;
      var overflowOffsets = {
        top: clippingClientRect.top - elementClientRect.top + paddingObject.top,
        bottom: elementClientRect.bottom - clippingClientRect.bottom + paddingObject.bottom,
        left: clippingClientRect.left - elementClientRect.left + paddingObject.left,
        right: elementClientRect.right - clippingClientRect.right + paddingObject.right
      };
      var offsetData = state.modifiersData.offset;
      if (elementContext === popper && offsetData) {
        var offset2 = offsetData[placement];
        Object.keys(overflowOffsets).forEach(function (key) {
          var multiply = [right, bottom].indexOf(key) >= 0 ? 1 : -1;
          var axis = [top, bottom].indexOf(key) >= 0 ? "y" : "x";
          overflowOffsets[key] += offset2[axis] * multiply;
        });
      }
      return overflowOffsets;
    }
    var INVALID_ELEMENT_ERROR = "Popper: Invalid reference or popper argument provided. They must be either a DOM element or virtual element.";
    var INFINITE_LOOP_ERROR = "Popper: An infinite loop in the modifiers cycle has been detected! The cycle has been interrupted to prevent a browser crash.";
    var DEFAULT_OPTIONS = {
      placement: "bottom",
      modifiers: [],
      strategy: "absolute"
    };
    function areValidElements() {
      for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }
      return !args.some(function (element) {
        return !(element && typeof element.getBoundingClientRect === "function");
      });
    }
    function popperGenerator(generatorOptions) {
      if (generatorOptions === void 0) {
        generatorOptions = {};
      }
      var _generatorOptions = generatorOptions,
        _generatorOptions$def = _generatorOptions.defaultModifiers,
        defaultModifiers2 = _generatorOptions$def === void 0 ? [] : _generatorOptions$def,
        _generatorOptions$def2 = _generatorOptions.defaultOptions,
        defaultOptions = _generatorOptions$def2 === void 0 ? DEFAULT_OPTIONS : _generatorOptions$def2;
      return function createPopper2(reference2, popper2, options) {
        if (options === void 0) {
          options = defaultOptions;
        }
        var state = {
          placement: "bottom",
          orderedModifiers: [],
          options: Object.assign({}, DEFAULT_OPTIONS, defaultOptions),
          modifiersData: {},
          elements: {
            reference: reference2,
            popper: popper2
          },
          attributes: {},
          styles: {}
        };
        var effectCleanupFns = [];
        var isDestroyed = false;
        var instance = {
          state,
          setOptions: function setOptions(options2) {
            cleanupModifierEffects();
            state.options = Object.assign({}, defaultOptions, state.options, options2);
            state.scrollParents = {
              reference: isElement(reference2) ? listScrollParents(reference2) : reference2.contextElement ? listScrollParents(reference2.contextElement) : [],
              popper: listScrollParents(popper2)
            };
            var orderedModifiers = orderModifiers(mergeByName([].concat(defaultModifiers2, state.options.modifiers)));
            state.orderedModifiers = orderedModifiers.filter(function (m) {
              return m.enabled;
            });
            {
              var modifiers = uniqueBy([].concat(orderedModifiers, state.options.modifiers), function (_ref) {
                var name = _ref.name;
                return name;
              });
              validateModifiers(modifiers);
              if (getBasePlacement(state.options.placement) === auto) {
                var flipModifier = state.orderedModifiers.find(function (_ref2) {
                  var name = _ref2.name;
                  return name === "flip";
                });
                if (!flipModifier) {
                  console.error(['Popper: "auto" placements require the "flip" modifier be', "present and enabled to work."].join(" "));
                }
              }
              var _getComputedStyle = getComputedStyle(popper2),
                marginTop = _getComputedStyle.marginTop,
                marginRight = _getComputedStyle.marginRight,
                marginBottom = _getComputedStyle.marginBottom,
                marginLeft = _getComputedStyle.marginLeft;
              if ([marginTop, marginRight, marginBottom, marginLeft].some(function (margin) {
                return parseFloat(margin);
              })) {
                console.warn(['Popper: CSS "margin" styles cannot be used to apply padding', "between the popper and its reference element or boundary.", "To replicate margin, use the `offset` modifier, as well as", "the `padding` option in the `preventOverflow` and `flip`", "modifiers."].join(" "));
              }
            }
            runModifierEffects();
            return instance.update();
          },
          forceUpdate: function forceUpdate() {
            if (isDestroyed) {
              return;
            }
            var _state$elements = state.elements,
              reference3 = _state$elements.reference,
              popper3 = _state$elements.popper;
            if (!areValidElements(reference3, popper3)) {
              {
                console.error(INVALID_ELEMENT_ERROR);
              }
              return;
            }
            state.rects = {
              reference: getCompositeRect(reference3, getOffsetParent(popper3), state.options.strategy === "fixed"),
              popper: getLayoutRect(popper3)
            };
            state.reset = false;
            state.placement = state.options.placement;
            state.orderedModifiers.forEach(function (modifier) {
              return state.modifiersData[modifier.name] = Object.assign({}, modifier.data);
            });
            var __debug_loops__ = 0;
            for (var index = 0; index < state.orderedModifiers.length; index++) {
              {
                __debug_loops__ += 1;
                if (__debug_loops__ > 100) {
                  console.error(INFINITE_LOOP_ERROR);
                  break;
                }
              }
              if (state.reset === true) {
                state.reset = false;
                index = -1;
                continue;
              }
              var _state$orderedModifie = state.orderedModifiers[index],
                fn = _state$orderedModifie.fn,
                _state$orderedModifie2 = _state$orderedModifie.options,
                _options = _state$orderedModifie2 === void 0 ? {} : _state$orderedModifie2,
                name = _state$orderedModifie.name;
              if (typeof fn === "function") {
                state = fn({
                  state,
                  options: _options,
                  name,
                  instance
                }) || state;
              }
            }
          },
          update: debounce(function () {
            return new Promise(function (resolve) {
              instance.forceUpdate();
              resolve(state);
            });
          }),
          destroy: function destroy() {
            cleanupModifierEffects();
            isDestroyed = true;
          }
        };
        if (!areValidElements(reference2, popper2)) {
          {
            console.error(INVALID_ELEMENT_ERROR);
          }
          return instance;
        }
        instance.setOptions(options).then(function (state2) {
          if (!isDestroyed && options.onFirstUpdate) {
            options.onFirstUpdate(state2);
          }
        });
        function runModifierEffects() {
          state.orderedModifiers.forEach(function (_ref3) {
            var name = _ref3.name,
              _ref3$options = _ref3.options,
              options2 = _ref3$options === void 0 ? {} : _ref3$options,
              effect2 = _ref3.effect;
            if (typeof effect2 === "function") {
              var cleanupFn = effect2({
                state,
                name,
                instance,
                options: options2
              });
              var noopFn = function noopFn2() {};
              effectCleanupFns.push(cleanupFn || noopFn);
            }
          });
        }
        function cleanupModifierEffects() {
          effectCleanupFns.forEach(function (fn) {
            return fn();
          });
          effectCleanupFns = [];
        }
        return instance;
      };
    }
    var passive = {
      passive: true
    };
    function effect$2(_ref) {
      var state = _ref.state,
        instance = _ref.instance,
        options = _ref.options;
      var _options$scroll = options.scroll,
        scroll = _options$scroll === void 0 ? true : _options$scroll,
        _options$resize = options.resize,
        resize = _options$resize === void 0 ? true : _options$resize;
      var window2 = getWindow(state.elements.popper);
      var scrollParents = [].concat(state.scrollParents.reference, state.scrollParents.popper);
      if (scroll) {
        scrollParents.forEach(function (scrollParent) {
          scrollParent.addEventListener("scroll", instance.update, passive);
        });
      }
      if (resize) {
        window2.addEventListener("resize", instance.update, passive);
      }
      return function () {
        if (scroll) {
          scrollParents.forEach(function (scrollParent) {
            scrollParent.removeEventListener("scroll", instance.update, passive);
          });
        }
        if (resize) {
          window2.removeEventListener("resize", instance.update, passive);
        }
      };
    }
    var eventListeners = {
      name: "eventListeners",
      enabled: true,
      phase: "write",
      fn: function fn() {},
      effect: effect$2,
      data: {}
    };
    function popperOffsets(_ref) {
      var state = _ref.state,
        name = _ref.name;
      state.modifiersData[name] = computeOffsets({
        reference: state.rects.reference,
        element: state.rects.popper,
        strategy: "absolute",
        placement: state.placement
      });
    }
    var popperOffsets$1 = {
      name: "popperOffsets",
      enabled: true,
      phase: "read",
      fn: popperOffsets,
      data: {}
    };
    var unsetSides = {
      top: "auto",
      right: "auto",
      bottom: "auto",
      left: "auto"
    };
    function roundOffsetsByDPR(_ref) {
      var x = _ref.x,
        y = _ref.y;
      var win = window;
      var dpr = win.devicePixelRatio || 1;
      return {
        x: round(round(x * dpr) / dpr) || 0,
        y: round(round(y * dpr) / dpr) || 0
      };
    }
    function mapToStyles(_ref2) {
      var _Object$assign2;
      var popper2 = _ref2.popper,
        popperRect = _ref2.popperRect,
        placement = _ref2.placement,
        offsets = _ref2.offsets,
        position = _ref2.position,
        gpuAcceleration = _ref2.gpuAcceleration,
        adaptive = _ref2.adaptive,
        roundOffsets = _ref2.roundOffsets;
      var _ref3 = roundOffsets === true ? roundOffsetsByDPR(offsets) : typeof roundOffsets === "function" ? roundOffsets(offsets) : offsets,
        _ref3$x = _ref3.x,
        x = _ref3$x === void 0 ? 0 : _ref3$x,
        _ref3$y = _ref3.y,
        y = _ref3$y === void 0 ? 0 : _ref3$y;
      var hasX = offsets.hasOwnProperty("x");
      var hasY = offsets.hasOwnProperty("y");
      var sideX = left;
      var sideY = top;
      var win = window;
      if (adaptive) {
        var offsetParent = getOffsetParent(popper2);
        var heightProp = "clientHeight";
        var widthProp = "clientWidth";
        if (offsetParent === getWindow(popper2)) {
          offsetParent = getDocumentElement(popper2);
          if (getComputedStyle(offsetParent).position !== "static") {
            heightProp = "scrollHeight";
            widthProp = "scrollWidth";
          }
        }
        offsetParent = offsetParent;
        if (placement === top) {
          sideY = bottom;
          y -= offsetParent[heightProp] - popperRect.height;
          y *= gpuAcceleration ? 1 : -1;
        }
        if (placement === left) {
          sideX = right;
          x -= offsetParent[widthProp] - popperRect.width;
          x *= gpuAcceleration ? 1 : -1;
        }
      }
      var commonStyles = Object.assign({
        position
      }, adaptive && unsetSides);
      if (gpuAcceleration) {
        var _Object$assign;
        return Object.assign({}, commonStyles, (_Object$assign = {}, _Object$assign[sideY] = hasY ? "0" : "", _Object$assign[sideX] = hasX ? "0" : "", _Object$assign.transform = (win.devicePixelRatio || 1) < 2 ? "translate(" + x + "px, " + y + "px)" : "translate3d(" + x + "px, " + y + "px, 0)", _Object$assign));
      }
      return Object.assign({}, commonStyles, (_Object$assign2 = {}, _Object$assign2[sideY] = hasY ? y + "px" : "", _Object$assign2[sideX] = hasX ? x + "px" : "", _Object$assign2.transform = "", _Object$assign2));
    }
    function computeStyles(_ref4) {
      var state = _ref4.state,
        options = _ref4.options;
      var _options$gpuAccelerat = options.gpuAcceleration,
        gpuAcceleration = _options$gpuAccelerat === void 0 ? true : _options$gpuAccelerat,
        _options$adaptive = options.adaptive,
        adaptive = _options$adaptive === void 0 ? true : _options$adaptive,
        _options$roundOffsets = options.roundOffsets,
        roundOffsets = _options$roundOffsets === void 0 ? true : _options$roundOffsets;
      {
        var transitionProperty = getComputedStyle(state.elements.popper).transitionProperty || "";
        if (adaptive && ["transform", "top", "right", "bottom", "left"].some(function (property) {
          return transitionProperty.indexOf(property) >= 0;
        })) {
          console.warn(["Popper: Detected CSS transitions on at least one of the following", 'CSS properties: "transform", "top", "right", "bottom", "left".', "\n\n", 'Disable the "computeStyles" modifier\'s `adaptive` option to allow', "for smooth transitions, or remove these properties from the CSS", "transition declaration on the popper element if only transitioning", "opacity or background-color for example.", "\n\n", "We recommend using the popper element as a wrapper around an inner", "element that can have any CSS property transitioned for animations."].join(" "));
        }
      }
      var commonStyles = {
        placement: getBasePlacement(state.placement),
        popper: state.elements.popper,
        popperRect: state.rects.popper,
        gpuAcceleration
      };
      if (state.modifiersData.popperOffsets != null) {
        state.styles.popper = Object.assign({}, state.styles.popper, mapToStyles(Object.assign({}, commonStyles, {
          offsets: state.modifiersData.popperOffsets,
          position: state.options.strategy,
          adaptive,
          roundOffsets
        })));
      }
      if (state.modifiersData.arrow != null) {
        state.styles.arrow = Object.assign({}, state.styles.arrow, mapToStyles(Object.assign({}, commonStyles, {
          offsets: state.modifiersData.arrow,
          position: "absolute",
          adaptive: false,
          roundOffsets
        })));
      }
      state.attributes.popper = Object.assign({}, state.attributes.popper, {
        "data-popper-placement": state.placement
      });
    }
    var computeStyles$1 = {
      name: "computeStyles",
      enabled: true,
      phase: "beforeWrite",
      fn: computeStyles,
      data: {}
    };
    function applyStyles(_ref) {
      var state = _ref.state;
      Object.keys(state.elements).forEach(function (name) {
        var style = state.styles[name] || {};
        var attributes = state.attributes[name] || {};
        var element = state.elements[name];
        if (!isHTMLElement(element) || !getNodeName(element)) {
          return;
        }
        Object.assign(element.style, style);
        Object.keys(attributes).forEach(function (name2) {
          var value = attributes[name2];
          if (value === false) {
            element.removeAttribute(name2);
          } else {
            element.setAttribute(name2, value === true ? "" : value);
          }
        });
      });
    }
    function effect$1(_ref2) {
      var state = _ref2.state;
      var initialStyles = {
        popper: {
          position: state.options.strategy,
          left: "0",
          top: "0",
          margin: "0"
        },
        arrow: {
          position: "absolute"
        },
        reference: {}
      };
      Object.assign(state.elements.popper.style, initialStyles.popper);
      state.styles = initialStyles;
      if (state.elements.arrow) {
        Object.assign(state.elements.arrow.style, initialStyles.arrow);
      }
      return function () {
        Object.keys(state.elements).forEach(function (name) {
          var element = state.elements[name];
          var attributes = state.attributes[name] || {};
          var styleProperties = Object.keys(state.styles.hasOwnProperty(name) ? state.styles[name] : initialStyles[name]);
          var style = styleProperties.reduce(function (style2, property) {
            style2[property] = "";
            return style2;
          }, {});
          if (!isHTMLElement(element) || !getNodeName(element)) {
            return;
          }
          Object.assign(element.style, style);
          Object.keys(attributes).forEach(function (attribute) {
            element.removeAttribute(attribute);
          });
        });
      };
    }
    var applyStyles$1 = {
      name: "applyStyles",
      enabled: true,
      phase: "write",
      fn: applyStyles,
      effect: effect$1,
      requires: ["computeStyles"]
    };
    function distanceAndSkiddingToXY(placement, rects, offset2) {
      var basePlacement = getBasePlacement(placement);
      var invertDistance = [left, top].indexOf(basePlacement) >= 0 ? -1 : 1;
      var _ref = typeof offset2 === "function" ? offset2(Object.assign({}, rects, {
          placement
        })) : offset2,
        skidding = _ref[0],
        distance = _ref[1];
      skidding = skidding || 0;
      distance = (distance || 0) * invertDistance;
      return [left, right].indexOf(basePlacement) >= 0 ? {
        x: distance,
        y: skidding
      } : {
        x: skidding,
        y: distance
      };
    }
    function offset(_ref2) {
      var state = _ref2.state,
        options = _ref2.options,
        name = _ref2.name;
      var _options$offset = options.offset,
        offset2 = _options$offset === void 0 ? [0, 0] : _options$offset;
      var data = placements.reduce(function (acc, placement) {
        acc[placement] = distanceAndSkiddingToXY(placement, state.rects, offset2);
        return acc;
      }, {});
      var _data$state$placement = data[state.placement],
        x = _data$state$placement.x,
        y = _data$state$placement.y;
      if (state.modifiersData.popperOffsets != null) {
        state.modifiersData.popperOffsets.x += x;
        state.modifiersData.popperOffsets.y += y;
      }
      state.modifiersData[name] = data;
    }
    var offset$1 = {
      name: "offset",
      enabled: true,
      phase: "main",
      requires: ["popperOffsets"],
      fn: offset
    };
    var hash$1 = {
      left: "right",
      right: "left",
      bottom: "top",
      top: "bottom"
    };
    function getOppositePlacement(placement) {
      return placement.replace(/left|right|bottom|top/g, function (matched) {
        return hash$1[matched];
      });
    }
    var hash = {
      start: "end",
      end: "start"
    };
    function getOppositeVariationPlacement(placement) {
      return placement.replace(/start|end/g, function (matched) {
        return hash[matched];
      });
    }
    function computeAutoPlacement(state, options) {
      if (options === void 0) {
        options = {};
      }
      var _options = options,
        placement = _options.placement,
        boundary = _options.boundary,
        rootBoundary = _options.rootBoundary,
        padding = _options.padding,
        flipVariations = _options.flipVariations,
        _options$allowedAutoP = _options.allowedAutoPlacements,
        allowedAutoPlacements = _options$allowedAutoP === void 0 ? placements : _options$allowedAutoP;
      var variation = getVariation(placement);
      var placements$1 = variation ? flipVariations ? variationPlacements : variationPlacements.filter(function (placement2) {
        return getVariation(placement2) === variation;
      }) : basePlacements;
      var allowedPlacements = placements$1.filter(function (placement2) {
        return allowedAutoPlacements.indexOf(placement2) >= 0;
      });
      if (allowedPlacements.length === 0) {
        allowedPlacements = placements$1;
        {
          console.error(["Popper: The `allowedAutoPlacements` option did not allow any", "placements. Ensure the `placement` option matches the variation", "of the allowed placements.", 'For example, "auto" cannot be used to allow "bottom-start".', 'Use "auto-start" instead.'].join(" "));
        }
      }
      var overflows = allowedPlacements.reduce(function (acc, placement2) {
        acc[placement2] = detectOverflow(state, {
          placement: placement2,
          boundary,
          rootBoundary,
          padding
        })[getBasePlacement(placement2)];
        return acc;
      }, {});
      return Object.keys(overflows).sort(function (a, b) {
        return overflows[a] - overflows[b];
      });
    }
    function getExpandedFallbackPlacements(placement) {
      if (getBasePlacement(placement) === auto) {
        return [];
      }
      var oppositePlacement = getOppositePlacement(placement);
      return [getOppositeVariationPlacement(placement), oppositePlacement, getOppositeVariationPlacement(oppositePlacement)];
    }
    function flip(_ref) {
      var state = _ref.state,
        options = _ref.options,
        name = _ref.name;
      if (state.modifiersData[name]._skip) {
        return;
      }
      var _options$mainAxis = options.mainAxis,
        checkMainAxis = _options$mainAxis === void 0 ? true : _options$mainAxis,
        _options$altAxis = options.altAxis,
        checkAltAxis = _options$altAxis === void 0 ? true : _options$altAxis,
        specifiedFallbackPlacements = options.fallbackPlacements,
        padding = options.padding,
        boundary = options.boundary,
        rootBoundary = options.rootBoundary,
        altBoundary = options.altBoundary,
        _options$flipVariatio = options.flipVariations,
        flipVariations = _options$flipVariatio === void 0 ? true : _options$flipVariatio,
        allowedAutoPlacements = options.allowedAutoPlacements;
      var preferredPlacement = state.options.placement;
      var basePlacement = getBasePlacement(preferredPlacement);
      var isBasePlacement = basePlacement === preferredPlacement;
      var fallbackPlacements = specifiedFallbackPlacements || (isBasePlacement || !flipVariations ? [getOppositePlacement(preferredPlacement)] : getExpandedFallbackPlacements(preferredPlacement));
      var placements2 = [preferredPlacement].concat(fallbackPlacements).reduce(function (acc, placement2) {
        return acc.concat(getBasePlacement(placement2) === auto ? computeAutoPlacement(state, {
          placement: placement2,
          boundary,
          rootBoundary,
          padding,
          flipVariations,
          allowedAutoPlacements
        }) : placement2);
      }, []);
      var referenceRect = state.rects.reference;
      var popperRect = state.rects.popper;
      var checksMap = new Map();
      var makeFallbackChecks = true;
      var firstFittingPlacement = placements2[0];
      for (var i = 0; i < placements2.length; i++) {
        var placement = placements2[i];
        var _basePlacement = getBasePlacement(placement);
        var isStartVariation = getVariation(placement) === start;
        var isVertical = [top, bottom].indexOf(_basePlacement) >= 0;
        var len = isVertical ? "width" : "height";
        var overflow = detectOverflow(state, {
          placement,
          boundary,
          rootBoundary,
          altBoundary,
          padding
        });
        var mainVariationSide = isVertical ? isStartVariation ? right : left : isStartVariation ? bottom : top;
        if (referenceRect[len] > popperRect[len]) {
          mainVariationSide = getOppositePlacement(mainVariationSide);
        }
        var altVariationSide = getOppositePlacement(mainVariationSide);
        var checks = [];
        if (checkMainAxis) {
          checks.push(overflow[_basePlacement] <= 0);
        }
        if (checkAltAxis) {
          checks.push(overflow[mainVariationSide] <= 0, overflow[altVariationSide] <= 0);
        }
        if (checks.every(function (check) {
          return check;
        })) {
          firstFittingPlacement = placement;
          makeFallbackChecks = false;
          break;
        }
        checksMap.set(placement, checks);
      }
      if (makeFallbackChecks) {
        var numberOfChecks = flipVariations ? 3 : 1;
        var _loop = function _loop2(_i2) {
          var fittingPlacement = placements2.find(function (placement2) {
            var checks2 = checksMap.get(placement2);
            if (checks2) {
              return checks2.slice(0, _i2).every(function (check) {
                return check;
              });
            }
          });
          if (fittingPlacement) {
            firstFittingPlacement = fittingPlacement;
            return "break";
          }
        };
        for (var _i = numberOfChecks; _i > 0; _i--) {
          var _ret = _loop(_i);
          if (_ret === "break") break;
        }
      }
      if (state.placement !== firstFittingPlacement) {
        state.modifiersData[name]._skip = true;
        state.placement = firstFittingPlacement;
        state.reset = true;
      }
    }
    var flip$1 = {
      name: "flip",
      enabled: true,
      phase: "main",
      fn: flip,
      requiresIfExists: ["offset"],
      data: {
        _skip: false
      }
    };
    function getAltAxis(axis) {
      return axis === "x" ? "y" : "x";
    }
    function within(min$1, value, max$1) {
      return max(min$1, min(value, max$1));
    }
    function preventOverflow(_ref) {
      var state = _ref.state,
        options = _ref.options,
        name = _ref.name;
      var _options$mainAxis = options.mainAxis,
        checkMainAxis = _options$mainAxis === void 0 ? true : _options$mainAxis,
        _options$altAxis = options.altAxis,
        checkAltAxis = _options$altAxis === void 0 ? false : _options$altAxis,
        boundary = options.boundary,
        rootBoundary = options.rootBoundary,
        altBoundary = options.altBoundary,
        padding = options.padding,
        _options$tether = options.tether,
        tether = _options$tether === void 0 ? true : _options$tether,
        _options$tetherOffset = options.tetherOffset,
        tetherOffset = _options$tetherOffset === void 0 ? 0 : _options$tetherOffset;
      var overflow = detectOverflow(state, {
        boundary,
        rootBoundary,
        padding,
        altBoundary
      });
      var basePlacement = getBasePlacement(state.placement);
      var variation = getVariation(state.placement);
      var isBasePlacement = !variation;
      var mainAxis = getMainAxisFromPlacement(basePlacement);
      var altAxis = getAltAxis(mainAxis);
      var popperOffsets2 = state.modifiersData.popperOffsets;
      var referenceRect = state.rects.reference;
      var popperRect = state.rects.popper;
      var tetherOffsetValue = typeof tetherOffset === "function" ? tetherOffset(Object.assign({}, state.rects, {
        placement: state.placement
      })) : tetherOffset;
      var data = {
        x: 0,
        y: 0
      };
      if (!popperOffsets2) {
        return;
      }
      if (checkMainAxis || checkAltAxis) {
        var mainSide = mainAxis === "y" ? top : left;
        var altSide = mainAxis === "y" ? bottom : right;
        var len = mainAxis === "y" ? "height" : "width";
        var offset2 = popperOffsets2[mainAxis];
        var min$1 = popperOffsets2[mainAxis] + overflow[mainSide];
        var max$1 = popperOffsets2[mainAxis] - overflow[altSide];
        var additive = tether ? -popperRect[len] / 2 : 0;
        var minLen = variation === start ? referenceRect[len] : popperRect[len];
        var maxLen = variation === start ? -popperRect[len] : -referenceRect[len];
        var arrowElement = state.elements.arrow;
        var arrowRect = tether && arrowElement ? getLayoutRect(arrowElement) : {
          width: 0,
          height: 0
        };
        var arrowPaddingObject = state.modifiersData["arrow#persistent"] ? state.modifiersData["arrow#persistent"].padding : getFreshSideObject();
        var arrowPaddingMin = arrowPaddingObject[mainSide];
        var arrowPaddingMax = arrowPaddingObject[altSide];
        var arrowLen = within(0, referenceRect[len], arrowRect[len]);
        var minOffset = isBasePlacement ? referenceRect[len] / 2 - additive - arrowLen - arrowPaddingMin - tetherOffsetValue : minLen - arrowLen - arrowPaddingMin - tetherOffsetValue;
        var maxOffset = isBasePlacement ? -referenceRect[len] / 2 + additive + arrowLen + arrowPaddingMax + tetherOffsetValue : maxLen + arrowLen + arrowPaddingMax + tetherOffsetValue;
        var arrowOffsetParent = state.elements.arrow && getOffsetParent(state.elements.arrow);
        var clientOffset = arrowOffsetParent ? mainAxis === "y" ? arrowOffsetParent.clientTop || 0 : arrowOffsetParent.clientLeft || 0 : 0;
        var offsetModifierValue = state.modifiersData.offset ? state.modifiersData.offset[state.placement][mainAxis] : 0;
        var tetherMin = popperOffsets2[mainAxis] + minOffset - offsetModifierValue - clientOffset;
        var tetherMax = popperOffsets2[mainAxis] + maxOffset - offsetModifierValue;
        if (checkMainAxis) {
          var preventedOffset = within(tether ? min(min$1, tetherMin) : min$1, offset2, tether ? max(max$1, tetherMax) : max$1);
          popperOffsets2[mainAxis] = preventedOffset;
          data[mainAxis] = preventedOffset - offset2;
        }
        if (checkAltAxis) {
          var _mainSide = mainAxis === "x" ? top : left;
          var _altSide = mainAxis === "x" ? bottom : right;
          var _offset = popperOffsets2[altAxis];
          var _min = _offset + overflow[_mainSide];
          var _max = _offset - overflow[_altSide];
          var _preventedOffset = within(tether ? min(_min, tetherMin) : _min, _offset, tether ? max(_max, tetherMax) : _max);
          popperOffsets2[altAxis] = _preventedOffset;
          data[altAxis] = _preventedOffset - _offset;
        }
      }
      state.modifiersData[name] = data;
    }
    var preventOverflow$1 = {
      name: "preventOverflow",
      enabled: true,
      phase: "main",
      fn: preventOverflow,
      requiresIfExists: ["offset"]
    };
    var toPaddingObject = function toPaddingObject2(padding, state) {
      padding = typeof padding === "function" ? padding(Object.assign({}, state.rects, {
        placement: state.placement
      })) : padding;
      return mergePaddingObject(typeof padding !== "number" ? padding : expandToHashMap(padding, basePlacements));
    };
    function arrow(_ref) {
      var _state$modifiersData$;
      var state = _ref.state,
        name = _ref.name,
        options = _ref.options;
      var arrowElement = state.elements.arrow;
      var popperOffsets2 = state.modifiersData.popperOffsets;
      var basePlacement = getBasePlacement(state.placement);
      var axis = getMainAxisFromPlacement(basePlacement);
      var isVertical = [left, right].indexOf(basePlacement) >= 0;
      var len = isVertical ? "height" : "width";
      if (!arrowElement || !popperOffsets2) {
        return;
      }
      var paddingObject = toPaddingObject(options.padding, state);
      var arrowRect = getLayoutRect(arrowElement);
      var minProp = axis === "y" ? top : left;
      var maxProp = axis === "y" ? bottom : right;
      var endDiff = state.rects.reference[len] + state.rects.reference[axis] - popperOffsets2[axis] - state.rects.popper[len];
      var startDiff = popperOffsets2[axis] - state.rects.reference[axis];
      var arrowOffsetParent = getOffsetParent(arrowElement);
      var clientSize = arrowOffsetParent ? axis === "y" ? arrowOffsetParent.clientHeight || 0 : arrowOffsetParent.clientWidth || 0 : 0;
      var centerToReference = endDiff / 2 - startDiff / 2;
      var min2 = paddingObject[minProp];
      var max2 = clientSize - arrowRect[len] - paddingObject[maxProp];
      var center = clientSize / 2 - arrowRect[len] / 2 + centerToReference;
      var offset2 = within(min2, center, max2);
      var axisProp = axis;
      state.modifiersData[name] = (_state$modifiersData$ = {}, _state$modifiersData$[axisProp] = offset2, _state$modifiersData$.centerOffset = offset2 - center, _state$modifiersData$);
    }
    function effect(_ref2) {
      var state = _ref2.state,
        options = _ref2.options;
      var _options$element = options.element,
        arrowElement = _options$element === void 0 ? "[data-popper-arrow]" : _options$element;
      if (arrowElement == null) {
        return;
      }
      if (typeof arrowElement === "string") {
        arrowElement = state.elements.popper.querySelector(arrowElement);
        if (!arrowElement) {
          return;
        }
      }
      {
        if (!isHTMLElement(arrowElement)) {
          console.error(['Popper: "arrow" element must be an HTMLElement (not an SVGElement).', "To use an SVG arrow, wrap it in an HTMLElement that will be used as", "the arrow."].join(" "));
        }
      }
      if (!contains(state.elements.popper, arrowElement)) {
        {
          console.error(['Popper: "arrow" modifier\'s `element` must be a child of the popper', "element."].join(" "));
        }
        return;
      }
      state.elements.arrow = arrowElement;
    }
    var arrow$1 = {
      name: "arrow",
      enabled: true,
      phase: "main",
      fn: arrow,
      effect,
      requires: ["popperOffsets"],
      requiresIfExists: ["preventOverflow"]
    };
    function getSideOffsets(overflow, rect, preventedOffsets) {
      if (preventedOffsets === void 0) {
        preventedOffsets = {
          x: 0,
          y: 0
        };
      }
      return {
        top: overflow.top - rect.height - preventedOffsets.y,
        right: overflow.right - rect.width + preventedOffsets.x,
        bottom: overflow.bottom - rect.height + preventedOffsets.y,
        left: overflow.left - rect.width - preventedOffsets.x
      };
    }
    function isAnySideFullyClipped(overflow) {
      return [top, right, bottom, left].some(function (side) {
        return overflow[side] >= 0;
      });
    }
    function hide(_ref) {
      var state = _ref.state,
        name = _ref.name;
      var referenceRect = state.rects.reference;
      var popperRect = state.rects.popper;
      var preventedOffsets = state.modifiersData.preventOverflow;
      var referenceOverflow = detectOverflow(state, {
        elementContext: "reference"
      });
      var popperAltOverflow = detectOverflow(state, {
        altBoundary: true
      });
      var referenceClippingOffsets = getSideOffsets(referenceOverflow, referenceRect);
      var popperEscapeOffsets = getSideOffsets(popperAltOverflow, popperRect, preventedOffsets);
      var isReferenceHidden = isAnySideFullyClipped(referenceClippingOffsets);
      var hasPopperEscaped = isAnySideFullyClipped(popperEscapeOffsets);
      state.modifiersData[name] = {
        referenceClippingOffsets,
        popperEscapeOffsets,
        isReferenceHidden,
        hasPopperEscaped
      };
      state.attributes.popper = Object.assign({}, state.attributes.popper, {
        "data-popper-reference-hidden": isReferenceHidden,
        "data-popper-escaped": hasPopperEscaped
      });
    }
    var hide$1 = {
      name: "hide",
      enabled: true,
      phase: "main",
      requiresIfExists: ["preventOverflow"],
      fn: hide
    };
    var defaultModifiers$1 = [eventListeners, popperOffsets$1, computeStyles$1, applyStyles$1];
    var createPopper$1 = /* @__PURE__ */popperGenerator({
      defaultModifiers: defaultModifiers$1
    });
    var defaultModifiers = [eventListeners, popperOffsets$1, computeStyles$1, applyStyles$1, offset$1, flip$1, preventOverflow$1, arrow$1, hide$1];
    var createPopper = /* @__PURE__ */popperGenerator({
      defaultModifiers
    });
    exports.applyStyles = applyStyles$1;
    exports.arrow = arrow$1;
    exports.computeStyles = computeStyles$1;
    exports.createPopper = createPopper;
    exports.createPopperLite = createPopper$1;
    exports.defaultModifiers = defaultModifiers;
    exports.detectOverflow = detectOverflow;
    exports.eventListeners = eventListeners;
    exports.flip = flip$1;
    exports.hide = hide$1;
    exports.offset = offset$1;
    exports.popperGenerator = popperGenerator;
    exports.popperOffsets = popperOffsets$1;
    exports.preventOverflow = preventOverflow$1;
  });

  // node_modules/tippy.js/dist/tippy.cjs.js
  var require_tippy_cjs = __commonJS(exports => {

    Object.defineProperty(exports, "__esModule", {
      value: true
    });
    var core = require_popper();
    var ROUND_ARROW = '<svg width="16" height="6" xmlns="http://www.w3.org/2000/svg"><path d="M0 6s1.796-.013 4.67-3.615C5.851.9 6.93.006 8 0c1.07-.006 2.148.887 3.343 2.385C14.233 6.005 16 6 16 6H0z"></svg>';
    var BOX_CLASS = "tippy-box";
    var CONTENT_CLASS = "tippy-content";
    var BACKDROP_CLASS = "tippy-backdrop";
    var ARROW_CLASS = "tippy-arrow";
    var SVG_ARROW_CLASS = "tippy-svg-arrow";
    var TOUCH_OPTIONS = {
      passive: true,
      capture: true
    };
    function hasOwnProperty(obj, key) {
      return {}.hasOwnProperty.call(obj, key);
    }
    function getValueAtIndexOrReturn(value, index, defaultValue) {
      if (Array.isArray(value)) {
        var v = value[index];
        return v == null ? Array.isArray(defaultValue) ? defaultValue[index] : defaultValue : v;
      }
      return value;
    }
    function isType(value, type) {
      var str = {}.toString.call(value);
      return str.indexOf("[object") === 0 && str.indexOf(type + "]") > -1;
    }
    function invokeWithArgsOrReturn(value, args) {
      return typeof value === "function" ? value.apply(void 0, args) : value;
    }
    function debounce(fn, ms) {
      if (ms === 0) {
        return fn;
      }
      var timeout;
      return function (arg) {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
          fn(arg);
        }, ms);
      };
    }
    function removeProperties(obj, keys) {
      var clone = Object.assign({}, obj);
      keys.forEach(function (key) {
        delete clone[key];
      });
      return clone;
    }
    function splitBySpaces(value) {
      return value.split(/\s+/).filter(Boolean);
    }
    function normalizeToArray(value) {
      return [].concat(value);
    }
    function pushIfUnique(arr, value) {
      if (arr.indexOf(value) === -1) {
        arr.push(value);
      }
    }
    function unique(arr) {
      return arr.filter(function (item, index) {
        return arr.indexOf(item) === index;
      });
    }
    function getBasePlacement(placement) {
      return placement.split("-")[0];
    }
    function arrayFrom(value) {
      return [].slice.call(value);
    }
    function removeUndefinedProps(obj) {
      return Object.keys(obj).reduce(function (acc, key) {
        if (obj[key] !== void 0) {
          acc[key] = obj[key];
        }
        return acc;
      }, {});
    }
    function div() {
      return document.createElement("div");
    }
    function isElement(value) {
      return ["Element", "Fragment"].some(function (type) {
        return isType(value, type);
      });
    }
    function isNodeList(value) {
      return isType(value, "NodeList");
    }
    function isMouseEvent(value) {
      return isType(value, "MouseEvent");
    }
    function isReferenceElement(value) {
      return !!(value && value._tippy && value._tippy.reference === value);
    }
    function getArrayOfElements(value) {
      if (isElement(value)) {
        return [value];
      }
      if (isNodeList(value)) {
        return arrayFrom(value);
      }
      if (Array.isArray(value)) {
        return value;
      }
      return arrayFrom(document.querySelectorAll(value));
    }
    function setTransitionDuration(els, value) {
      els.forEach(function (el) {
        if (el) {
          el.style.transitionDuration = value + "ms";
        }
      });
    }
    function setVisibilityState(els, state) {
      els.forEach(function (el) {
        if (el) {
          el.setAttribute("data-state", state);
        }
      });
    }
    function getOwnerDocument(elementOrElements) {
      var _element$ownerDocumen;
      var _normalizeToArray = normalizeToArray(elementOrElements),
        element = _normalizeToArray[0];
      return (element == null ? void 0 : (_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body) ? element.ownerDocument : document;
    }
    function isCursorOutsideInteractiveBorder(popperTreeData, event) {
      var clientX = event.clientX,
        clientY = event.clientY;
      return popperTreeData.every(function (_ref) {
        var popperRect = _ref.popperRect,
          popperState = _ref.popperState,
          props = _ref.props;
        var interactiveBorder = props.interactiveBorder;
        var basePlacement = getBasePlacement(popperState.placement);
        var offsetData = popperState.modifiersData.offset;
        if (!offsetData) {
          return true;
        }
        var topDistance = basePlacement === "bottom" ? offsetData.top.y : 0;
        var bottomDistance = basePlacement === "top" ? offsetData.bottom.y : 0;
        var leftDistance = basePlacement === "right" ? offsetData.left.x : 0;
        var rightDistance = basePlacement === "left" ? offsetData.right.x : 0;
        var exceedsTop = popperRect.top - clientY + topDistance > interactiveBorder;
        var exceedsBottom = clientY - popperRect.bottom - bottomDistance > interactiveBorder;
        var exceedsLeft = popperRect.left - clientX + leftDistance > interactiveBorder;
        var exceedsRight = clientX - popperRect.right - rightDistance > interactiveBorder;
        return exceedsTop || exceedsBottom || exceedsLeft || exceedsRight;
      });
    }
    function updateTransitionEndListener(box, action, listener) {
      var method = action + "EventListener";
      ["transitionend", "webkitTransitionEnd"].forEach(function (event) {
        box[method](event, listener);
      });
    }
    var currentInput = {
      isTouch: false
    };
    var lastMouseMoveTime = 0;
    function onDocumentTouchStart() {
      if (currentInput.isTouch) {
        return;
      }
      currentInput.isTouch = true;
      if (window.performance) {
        document.addEventListener("mousemove", onDocumentMouseMove);
      }
    }
    function onDocumentMouseMove() {
      var now = performance.now();
      if (now - lastMouseMoveTime < 20) {
        currentInput.isTouch = false;
        document.removeEventListener("mousemove", onDocumentMouseMove);
      }
      lastMouseMoveTime = now;
    }
    function onWindowBlur() {
      var activeElement = document.activeElement;
      if (isReferenceElement(activeElement)) {
        var instance = activeElement._tippy;
        if (activeElement.blur && !instance.state.isVisible) {
          activeElement.blur();
        }
      }
    }
    function bindGlobalEventListeners() {
      document.addEventListener("touchstart", onDocumentTouchStart, TOUCH_OPTIONS);
      window.addEventListener("blur", onWindowBlur);
    }
    var isBrowser = typeof window !== "undefined" && typeof document !== "undefined";
    var ua = isBrowser ? navigator.userAgent : "";
    var isIE = /MSIE |Trident\//.test(ua);
    function createMemoryLeakWarning(method) {
      var txt = method === "destroy" ? "n already-" : " ";
      return [method + "() was called on a" + txt + "destroyed instance. This is a no-op but", "indicates a potential memory leak."].join(" ");
    }
    function clean(value) {
      var spacesAndTabs = /[ \t]{2,}/g;
      var lineStartWithSpaces = /^[ \t]*/gm;
      return value.replace(spacesAndTabs, " ").replace(lineStartWithSpaces, "").trim();
    }
    function getDevMessage(message) {
      return clean("\n  %ctippy.js\n\n  %c" + clean(message) + "\n\n  %c\u{1F477}\u200D This is a development-only message. It will be removed in production.\n  ");
    }
    function getFormattedMessage(message) {
      return [getDevMessage(message), "color: #00C584; font-size: 1.3em; font-weight: bold;", "line-height: 1.5", "color: #a6a095;"];
    }
    var visitedMessages;
    {
      resetVisitedMessages();
    }
    function resetVisitedMessages() {
      visitedMessages = new Set();
    }
    function warnWhen(condition, message) {
      if (condition && !visitedMessages.has(message)) {
        var _console;
        visitedMessages.add(message);
        (_console = console).warn.apply(_console, getFormattedMessage(message));
      }
    }
    function errorWhen(condition, message) {
      if (condition && !visitedMessages.has(message)) {
        var _console2;
        visitedMessages.add(message);
        (_console2 = console).error.apply(_console2, getFormattedMessage(message));
      }
    }
    function validateTargets(targets) {
      var didPassFalsyValue = !targets;
      var didPassPlainObject = Object.prototype.toString.call(targets) === "[object Object]" && !targets.addEventListener;
      errorWhen(didPassFalsyValue, ["tippy() was passed", "`" + String(targets) + "`", "as its targets (first) argument. Valid types are: String, Element,", "Element[], or NodeList."].join(" "));
      errorWhen(didPassPlainObject, ["tippy() was passed a plain object which is not supported as an argument", "for virtual positioning. Use props.getReferenceClientRect instead."].join(" "));
    }
    var pluginProps = {
      animateFill: false,
      followCursor: false,
      inlinePositioning: false,
      sticky: false
    };
    var renderProps = {
      allowHTML: false,
      animation: "fade",
      arrow: true,
      content: "",
      inertia: false,
      maxWidth: 350,
      role: "tooltip",
      theme: "",
      zIndex: 9999
    };
    var defaultProps = Object.assign({
      appendTo: function appendTo() {
        return document.body;
      },
      aria: {
        content: "auto",
        expanded: "auto"
      },
      delay: 0,
      duration: [300, 250],
      getReferenceClientRect: null,
      hideOnClick: true,
      ignoreAttributes: false,
      interactive: false,
      interactiveBorder: 2,
      interactiveDebounce: 0,
      moveTransition: "",
      offset: [0, 10],
      onAfterUpdate: function onAfterUpdate() {},
      onBeforeUpdate: function onBeforeUpdate() {},
      onCreate: function onCreate() {},
      onDestroy: function onDestroy() {},
      onHidden: function onHidden() {},
      onHide: function onHide() {},
      onMount: function onMount() {},
      onShow: function onShow() {},
      onShown: function onShown() {},
      onTrigger: function onTrigger() {},
      onUntrigger: function onUntrigger() {},
      onClickOutside: function onClickOutside() {},
      placement: "top",
      plugins: [],
      popperOptions: {},
      render: null,
      showOnCreate: false,
      touch: true,
      trigger: "mouseenter focus",
      triggerTarget: null
    }, pluginProps, {}, renderProps);
    var defaultKeys = Object.keys(defaultProps);
    var setDefaultProps = function setDefaultProps2(partialProps) {
      {
        validateProps(partialProps, []);
      }
      var keys = Object.keys(partialProps);
      keys.forEach(function (key) {
        defaultProps[key] = partialProps[key];
      });
    };
    function getExtendedPassedProps(passedProps) {
      var plugins = passedProps.plugins || [];
      var pluginProps2 = plugins.reduce(function (acc, plugin) {
        var name = plugin.name,
          defaultValue = plugin.defaultValue;
        if (name) {
          acc[name] = passedProps[name] !== void 0 ? passedProps[name] : defaultValue;
        }
        return acc;
      }, {});
      return Object.assign({}, passedProps, {}, pluginProps2);
    }
    function getDataAttributeProps(reference, plugins) {
      var propKeys = plugins ? Object.keys(getExtendedPassedProps(Object.assign({}, defaultProps, {
        plugins
      }))) : defaultKeys;
      var props = propKeys.reduce(function (acc, key) {
        var valueAsString = (reference.getAttribute("data-tippy-" + key) || "").trim();
        if (!valueAsString) {
          return acc;
        }
        if (key === "content") {
          acc[key] = valueAsString;
        } else {
          try {
            acc[key] = JSON.parse(valueAsString);
          } catch (e) {
            acc[key] = valueAsString;
          }
        }
        return acc;
      }, {});
      return props;
    }
    function evaluateProps(reference, props) {
      var out = Object.assign({}, props, {
        content: invokeWithArgsOrReturn(props.content, [reference])
      }, props.ignoreAttributes ? {} : getDataAttributeProps(reference, props.plugins));
      out.aria = Object.assign({}, defaultProps.aria, {}, out.aria);
      out.aria = {
        expanded: out.aria.expanded === "auto" ? props.interactive : out.aria.expanded,
        content: out.aria.content === "auto" ? props.interactive ? null : "describedby" : out.aria.content
      };
      return out;
    }
    function validateProps(partialProps, plugins) {
      if (partialProps === void 0) {
        partialProps = {};
      }
      if (plugins === void 0) {
        plugins = [];
      }
      var keys = Object.keys(partialProps);
      keys.forEach(function (prop) {
        var nonPluginProps = removeProperties(defaultProps, Object.keys(pluginProps));
        var didPassUnknownProp = !hasOwnProperty(nonPluginProps, prop);
        if (didPassUnknownProp) {
          didPassUnknownProp = plugins.filter(function (plugin) {
            return plugin.name === prop;
          }).length === 0;
        }
        warnWhen(didPassUnknownProp, ["`" + prop + "`", "is not a valid prop. You may have spelled it incorrectly, or if it's", "a plugin, forgot to pass it in an array as props.plugins.", "\n\n", "All props: https://atomiks.github.io/tippyjs/v6/all-props/\n", "Plugins: https://atomiks.github.io/tippyjs/v6/plugins/"].join(" "));
      });
    }
    var innerHTML = function innerHTML2() {
      return "innerHTML";
    };
    function dangerouslySetInnerHTML(element, html) {
      element[innerHTML()] = html;
    }
    function createArrowElement(value) {
      var arrow = div();
      if (value === true) {
        arrow.className = ARROW_CLASS;
      } else {
        arrow.className = SVG_ARROW_CLASS;
        if (isElement(value)) {
          arrow.appendChild(value);
        } else {
          dangerouslySetInnerHTML(arrow, value);
        }
      }
      return arrow;
    }
    function setContent(content, props) {
      if (isElement(props.content)) {
        dangerouslySetInnerHTML(content, "");
        content.appendChild(props.content);
      } else if (typeof props.content !== "function") {
        if (props.allowHTML) {
          dangerouslySetInnerHTML(content, props.content);
        } else {
          content.textContent = props.content;
        }
      }
    }
    function getChildren(popper) {
      var box = popper.firstElementChild;
      var boxChildren = arrayFrom(box.children);
      return {
        box,
        content: boxChildren.find(function (node) {
          return node.classList.contains(CONTENT_CLASS);
        }),
        arrow: boxChildren.find(function (node) {
          return node.classList.contains(ARROW_CLASS) || node.classList.contains(SVG_ARROW_CLASS);
        }),
        backdrop: boxChildren.find(function (node) {
          return node.classList.contains(BACKDROP_CLASS);
        })
      };
    }
    function render(instance) {
      var popper = div();
      var box = div();
      box.className = BOX_CLASS;
      box.setAttribute("data-state", "hidden");
      box.setAttribute("tabindex", "-1");
      var content = div();
      content.className = CONTENT_CLASS;
      content.setAttribute("data-state", "hidden");
      setContent(content, instance.props);
      popper.appendChild(box);
      box.appendChild(content);
      onUpdate(instance.props, instance.props);
      function onUpdate(prevProps, nextProps) {
        var _getChildren = getChildren(popper),
          box2 = _getChildren.box,
          content2 = _getChildren.content,
          arrow = _getChildren.arrow;
        if (nextProps.theme) {
          box2.setAttribute("data-theme", nextProps.theme);
        } else {
          box2.removeAttribute("data-theme");
        }
        if (typeof nextProps.animation === "string") {
          box2.setAttribute("data-animation", nextProps.animation);
        } else {
          box2.removeAttribute("data-animation");
        }
        if (nextProps.inertia) {
          box2.setAttribute("data-inertia", "");
        } else {
          box2.removeAttribute("data-inertia");
        }
        box2.style.maxWidth = typeof nextProps.maxWidth === "number" ? nextProps.maxWidth + "px" : nextProps.maxWidth;
        if (nextProps.role) {
          box2.setAttribute("role", nextProps.role);
        } else {
          box2.removeAttribute("role");
        }
        if (prevProps.content !== nextProps.content || prevProps.allowHTML !== nextProps.allowHTML) {
          setContent(content2, instance.props);
        }
        if (nextProps.arrow) {
          if (!arrow) {
            box2.appendChild(createArrowElement(nextProps.arrow));
          } else if (prevProps.arrow !== nextProps.arrow) {
            box2.removeChild(arrow);
            box2.appendChild(createArrowElement(nextProps.arrow));
          }
        } else if (arrow) {
          box2.removeChild(arrow);
        }
      }
      return {
        popper,
        onUpdate
      };
    }
    render.$$tippy = true;
    var idCounter = 1;
    var mouseMoveListeners = [];
    var mountedInstances = [];
    function createTippy(reference, passedProps) {
      var props = evaluateProps(reference, Object.assign({}, defaultProps, {}, getExtendedPassedProps(removeUndefinedProps(passedProps))));
      var showTimeout;
      var hideTimeout;
      var scheduleHideAnimationFrame;
      var isVisibleFromClick = false;
      var didHideDueToDocumentMouseDown = false;
      var didTouchMove = false;
      var ignoreOnFirstUpdate = false;
      var lastTriggerEvent;
      var currentTransitionEndListener;
      var onFirstUpdate;
      var listeners = [];
      var debouncedOnMouseMove = debounce(onMouseMove, props.interactiveDebounce);
      var currentTarget;
      var id = idCounter++;
      var popperInstance = null;
      var plugins = unique(props.plugins);
      var state = {
        isEnabled: true,
        isVisible: false,
        isDestroyed: false,
        isMounted: false,
        isShown: false
      };
      var instance = {
        id,
        reference,
        popper: div(),
        popperInstance,
        props,
        state,
        plugins,
        clearDelayTimeouts,
        setProps,
        setContent: setContent2,
        show,
        hide,
        hideWithInteractivity,
        enable,
        disable,
        unmount,
        destroy
      };
      if (!props.render) {
        {
          errorWhen(true, "render() function has not been supplied.");
        }
        return instance;
      }
      var _props$render = props.render(instance),
        popper = _props$render.popper,
        onUpdate = _props$render.onUpdate;
      popper.setAttribute("data-tippy-root", "");
      popper.id = "tippy-" + instance.id;
      instance.popper = popper;
      reference._tippy = instance;
      popper._tippy = instance;
      var pluginsHooks = plugins.map(function (plugin) {
        return plugin.fn(instance);
      });
      var hasAriaExpanded = reference.hasAttribute("aria-expanded");
      addListeners();
      handleAriaExpandedAttribute();
      handleStyles();
      invokeHook("onCreate", [instance]);
      if (props.showOnCreate) {
        scheduleShow();
      }
      popper.addEventListener("mouseenter", function () {
        if (instance.props.interactive && instance.state.isVisible) {
          instance.clearDelayTimeouts();
        }
      });
      popper.addEventListener("mouseleave", function (event) {
        if (instance.props.interactive && instance.props.trigger.indexOf("mouseenter") >= 0) {
          getDocument().addEventListener("mousemove", debouncedOnMouseMove);
          debouncedOnMouseMove(event);
        }
      });
      return instance;
      function getNormalizedTouchSettings() {
        var touch = instance.props.touch;
        return Array.isArray(touch) ? touch : [touch, 0];
      }
      function getIsCustomTouchBehavior() {
        return getNormalizedTouchSettings()[0] === "hold";
      }
      function getIsDefaultRenderFn() {
        var _instance$props$rende;
        return !!((_instance$props$rende = instance.props.render) == null ? void 0 : _instance$props$rende.$$tippy);
      }
      function getCurrentTarget() {
        return currentTarget || reference;
      }
      function getDocument() {
        var parent = getCurrentTarget().parentNode;
        return parent ? getOwnerDocument(parent) : document;
      }
      function getDefaultTemplateChildren() {
        return getChildren(popper);
      }
      function getDelay(isShow) {
        if (instance.state.isMounted && !instance.state.isVisible || currentInput.isTouch || lastTriggerEvent && lastTriggerEvent.type === "focus") {
          return 0;
        }
        return getValueAtIndexOrReturn(instance.props.delay, isShow ? 0 : 1, defaultProps.delay);
      }
      function handleStyles() {
        popper.style.pointerEvents = instance.props.interactive && instance.state.isVisible ? "" : "none";
        popper.style.zIndex = "" + instance.props.zIndex;
      }
      function invokeHook(hook, args, shouldInvokePropsHook) {
        if (shouldInvokePropsHook === void 0) {
          shouldInvokePropsHook = true;
        }
        pluginsHooks.forEach(function (pluginHooks) {
          if (pluginHooks[hook]) {
            pluginHooks[hook].apply(void 0, args);
          }
        });
        if (shouldInvokePropsHook) {
          var _instance$props;
          (_instance$props = instance.props)[hook].apply(_instance$props, args);
        }
      }
      function handleAriaContentAttribute() {
        var aria = instance.props.aria;
        if (!aria.content) {
          return;
        }
        var attr = "aria-" + aria.content;
        var id2 = popper.id;
        var nodes = normalizeToArray(instance.props.triggerTarget || reference);
        nodes.forEach(function (node) {
          var currentValue = node.getAttribute(attr);
          if (instance.state.isVisible) {
            node.setAttribute(attr, currentValue ? currentValue + " " + id2 : id2);
          } else {
            var nextValue = currentValue && currentValue.replace(id2, "").trim();
            if (nextValue) {
              node.setAttribute(attr, nextValue);
            } else {
              node.removeAttribute(attr);
            }
          }
        });
      }
      function handleAriaExpandedAttribute() {
        if (hasAriaExpanded || !instance.props.aria.expanded) {
          return;
        }
        var nodes = normalizeToArray(instance.props.triggerTarget || reference);
        nodes.forEach(function (node) {
          if (instance.props.interactive) {
            node.setAttribute("aria-expanded", instance.state.isVisible && node === getCurrentTarget() ? "true" : "false");
          } else {
            node.removeAttribute("aria-expanded");
          }
        });
      }
      function cleanupInteractiveMouseListeners() {
        getDocument().removeEventListener("mousemove", debouncedOnMouseMove);
        mouseMoveListeners = mouseMoveListeners.filter(function (listener) {
          return listener !== debouncedOnMouseMove;
        });
      }
      function onDocumentPress(event) {
        if (currentInput.isTouch) {
          if (didTouchMove || event.type === "mousedown") {
            return;
          }
        }
        if (instance.props.interactive && popper.contains(event.target)) {
          return;
        }
        if (getCurrentTarget().contains(event.target)) {
          if (currentInput.isTouch) {
            return;
          }
          if (instance.state.isVisible && instance.props.trigger.indexOf("click") >= 0) {
            return;
          }
        } else {
          invokeHook("onClickOutside", [instance, event]);
        }
        if (instance.props.hideOnClick === true) {
          instance.clearDelayTimeouts();
          instance.hide();
          didHideDueToDocumentMouseDown = true;
          setTimeout(function () {
            didHideDueToDocumentMouseDown = false;
          });
          if (!instance.state.isMounted) {
            removeDocumentPress();
          }
        }
      }
      function onTouchMove() {
        didTouchMove = true;
      }
      function onTouchStart() {
        didTouchMove = false;
      }
      function addDocumentPress() {
        var doc = getDocument();
        doc.addEventListener("mousedown", onDocumentPress, true);
        doc.addEventListener("touchend", onDocumentPress, TOUCH_OPTIONS);
        doc.addEventListener("touchstart", onTouchStart, TOUCH_OPTIONS);
        doc.addEventListener("touchmove", onTouchMove, TOUCH_OPTIONS);
      }
      function removeDocumentPress() {
        var doc = getDocument();
        doc.removeEventListener("mousedown", onDocumentPress, true);
        doc.removeEventListener("touchend", onDocumentPress, TOUCH_OPTIONS);
        doc.removeEventListener("touchstart", onTouchStart, TOUCH_OPTIONS);
        doc.removeEventListener("touchmove", onTouchMove, TOUCH_OPTIONS);
      }
      function onTransitionedOut(duration, callback) {
        onTransitionEnd(duration, function () {
          if (!instance.state.isVisible && popper.parentNode && popper.parentNode.contains(popper)) {
            callback();
          }
        });
      }
      function onTransitionedIn(duration, callback) {
        onTransitionEnd(duration, callback);
      }
      function onTransitionEnd(duration, callback) {
        var box = getDefaultTemplateChildren().box;
        function listener(event) {
          if (event.target === box) {
            updateTransitionEndListener(box, "remove", listener);
            callback();
          }
        }
        if (duration === 0) {
          return callback();
        }
        updateTransitionEndListener(box, "remove", currentTransitionEndListener);
        updateTransitionEndListener(box, "add", listener);
        currentTransitionEndListener = listener;
      }
      function on(eventType, handler, options) {
        if (options === void 0) {
          options = false;
        }
        var nodes = normalizeToArray(instance.props.triggerTarget || reference);
        nodes.forEach(function (node) {
          node.addEventListener(eventType, handler, options);
          listeners.push({
            node,
            eventType,
            handler,
            options
          });
        });
      }
      function addListeners() {
        if (getIsCustomTouchBehavior()) {
          on("touchstart", onTrigger, {
            passive: true
          });
          on("touchend", onMouseLeave, {
            passive: true
          });
        }
        splitBySpaces(instance.props.trigger).forEach(function (eventType) {
          if (eventType === "manual") {
            return;
          }
          on(eventType, onTrigger);
          switch (eventType) {
            case "mouseenter":
              on("mouseleave", onMouseLeave);
              break;
            case "focus":
              on(isIE ? "focusout" : "blur", onBlurOrFocusOut);
              break;
            case "focusin":
              on("focusout", onBlurOrFocusOut);
              break;
          }
        });
      }
      function removeListeners() {
        listeners.forEach(function (_ref) {
          var node = _ref.node,
            eventType = _ref.eventType,
            handler = _ref.handler,
            options = _ref.options;
          node.removeEventListener(eventType, handler, options);
        });
        listeners = [];
      }
      function onTrigger(event) {
        var _lastTriggerEvent;
        var shouldScheduleClickHide = false;
        if (!instance.state.isEnabled || isEventListenerStopped(event) || didHideDueToDocumentMouseDown) {
          return;
        }
        var wasFocused = ((_lastTriggerEvent = lastTriggerEvent) == null ? void 0 : _lastTriggerEvent.type) === "focus";
        lastTriggerEvent = event;
        currentTarget = event.currentTarget;
        handleAriaExpandedAttribute();
        if (!instance.state.isVisible && isMouseEvent(event)) {
          mouseMoveListeners.forEach(function (listener) {
            return listener(event);
          });
        }
        if (event.type === "click" && (instance.props.trigger.indexOf("mouseenter") < 0 || isVisibleFromClick) && instance.props.hideOnClick !== false && instance.state.isVisible) {
          shouldScheduleClickHide = true;
        } else {
          scheduleShow(event);
        }
        if (event.type === "click") {
          isVisibleFromClick = !shouldScheduleClickHide;
        }
        if (shouldScheduleClickHide && !wasFocused) {
          scheduleHide(event);
        }
      }
      function onMouseMove(event) {
        var target = event.target;
        var isCursorOverReferenceOrPopper = getCurrentTarget().contains(target) || popper.contains(target);
        if (event.type === "mousemove" && isCursorOverReferenceOrPopper) {
          return;
        }
        var popperTreeData = getNestedPopperTree().concat(popper).map(function (popper2) {
          var _instance$popperInsta;
          var instance2 = popper2._tippy;
          var state2 = (_instance$popperInsta = instance2.popperInstance) == null ? void 0 : _instance$popperInsta.state;
          if (state2) {
            return {
              popperRect: popper2.getBoundingClientRect(),
              popperState: state2,
              props
            };
          }
          return null;
        }).filter(Boolean);
        if (isCursorOutsideInteractiveBorder(popperTreeData, event)) {
          cleanupInteractiveMouseListeners();
          scheduleHide(event);
        }
      }
      function onMouseLeave(event) {
        var shouldBail = isEventListenerStopped(event) || instance.props.trigger.indexOf("click") >= 0 && isVisibleFromClick;
        if (shouldBail) {
          return;
        }
        if (instance.props.interactive) {
          instance.hideWithInteractivity(event);
          return;
        }
        scheduleHide(event);
      }
      function onBlurOrFocusOut(event) {
        if (instance.props.trigger.indexOf("focusin") < 0 && event.target !== getCurrentTarget()) {
          return;
        }
        if (instance.props.interactive && event.relatedTarget && popper.contains(event.relatedTarget)) {
          return;
        }
        scheduleHide(event);
      }
      function isEventListenerStopped(event) {
        return currentInput.isTouch ? getIsCustomTouchBehavior() !== event.type.indexOf("touch") >= 0 : false;
      }
      function createPopperInstance() {
        destroyPopperInstance();
        var _instance$props2 = instance.props,
          popperOptions = _instance$props2.popperOptions,
          placement = _instance$props2.placement,
          offset = _instance$props2.offset,
          getReferenceClientRect = _instance$props2.getReferenceClientRect,
          moveTransition = _instance$props2.moveTransition;
        var arrow = getIsDefaultRenderFn() ? getChildren(popper).arrow : null;
        var computedReference = getReferenceClientRect ? {
          getBoundingClientRect: getReferenceClientRect,
          contextElement: getReferenceClientRect.contextElement || getCurrentTarget()
        } : reference;
        var tippyModifier = {
          name: "$$tippy",
          enabled: true,
          phase: "beforeWrite",
          requires: ["computeStyles"],
          fn: function fn(_ref2) {
            var state2 = _ref2.state;
            if (getIsDefaultRenderFn()) {
              var _getDefaultTemplateCh = getDefaultTemplateChildren(),
                box = _getDefaultTemplateCh.box;
              ["placement", "reference-hidden", "escaped"].forEach(function (attr) {
                if (attr === "placement") {
                  box.setAttribute("data-placement", state2.placement);
                } else {
                  if (state2.attributes.popper["data-popper-" + attr]) {
                    box.setAttribute("data-" + attr, "");
                  } else {
                    box.removeAttribute("data-" + attr);
                  }
                }
              });
              state2.attributes.popper = {};
            }
          }
        };
        var modifiers = [{
          name: "offset",
          options: {
            offset
          }
        }, {
          name: "preventOverflow",
          options: {
            padding: {
              top: 2,
              bottom: 2,
              left: 5,
              right: 5
            }
          }
        }, {
          name: "flip",
          options: {
            padding: 5
          }
        }, {
          name: "computeStyles",
          options: {
            adaptive: !moveTransition
          }
        }, tippyModifier];
        if (getIsDefaultRenderFn() && arrow) {
          modifiers.push({
            name: "arrow",
            options: {
              element: arrow,
              padding: 3
            }
          });
        }
        modifiers.push.apply(modifiers, (popperOptions == null ? void 0 : popperOptions.modifiers) || []);
        instance.popperInstance = core.createPopper(computedReference, popper, Object.assign({}, popperOptions, {
          placement,
          onFirstUpdate,
          modifiers
        }));
      }
      function destroyPopperInstance() {
        if (instance.popperInstance) {
          instance.popperInstance.destroy();
          instance.popperInstance = null;
        }
      }
      function mount() {
        var appendTo = instance.props.appendTo;
        var parentNode;
        var node = getCurrentTarget();
        if (instance.props.interactive && appendTo === defaultProps.appendTo || appendTo === "parent") {
          parentNode = node.parentNode;
        } else {
          parentNode = invokeWithArgsOrReturn(appendTo, [node]);
        }
        if (!parentNode.contains(popper)) {
          parentNode.appendChild(popper);
        }
        createPopperInstance();
        {
          warnWhen(instance.props.interactive && appendTo === defaultProps.appendTo && node.nextElementSibling !== popper, ["Interactive tippy element may not be accessible via keyboard", "navigation because it is not directly after the reference element", "in the DOM source order.", "\n\n", "Using a wrapper <div> or <span> tag around the reference element", "solves this by creating a new parentNode context.", "\n\n", "Specifying `appendTo: document.body` silences this warning, but it", "assumes you are using a focus management solution to handle", "keyboard navigation.", "\n\n", "See: https://atomiks.github.io/tippyjs/v6/accessibility/#interactivity"].join(" "));
        }
      }
      function getNestedPopperTree() {
        return arrayFrom(popper.querySelectorAll("[data-tippy-root]"));
      }
      function scheduleShow(event) {
        instance.clearDelayTimeouts();
        if (event) {
          invokeHook("onTrigger", [instance, event]);
        }
        addDocumentPress();
        var delay = getDelay(true);
        var _getNormalizedTouchSe = getNormalizedTouchSettings(),
          touchValue = _getNormalizedTouchSe[0],
          touchDelay = _getNormalizedTouchSe[1];
        if (currentInput.isTouch && touchValue === "hold" && touchDelay) {
          delay = touchDelay;
        }
        if (delay) {
          showTimeout = setTimeout(function () {
            instance.show();
          }, delay);
        } else {
          instance.show();
        }
      }
      function scheduleHide(event) {
        instance.clearDelayTimeouts();
        invokeHook("onUntrigger", [instance, event]);
        if (!instance.state.isVisible) {
          removeDocumentPress();
          return;
        }
        if (instance.props.trigger.indexOf("mouseenter") >= 0 && instance.props.trigger.indexOf("click") >= 0 && ["mouseleave", "mousemove"].indexOf(event.type) >= 0 && isVisibleFromClick) {
          return;
        }
        var delay = getDelay(false);
        if (delay) {
          hideTimeout = setTimeout(function () {
            if (instance.state.isVisible) {
              instance.hide();
            }
          }, delay);
        } else {
          scheduleHideAnimationFrame = requestAnimationFrame(function () {
            instance.hide();
          });
        }
      }
      function enable() {
        instance.state.isEnabled = true;
      }
      function disable() {
        instance.hide();
        instance.state.isEnabled = false;
      }
      function clearDelayTimeouts() {
        clearTimeout(showTimeout);
        clearTimeout(hideTimeout);
        cancelAnimationFrame(scheduleHideAnimationFrame);
      }
      function setProps(partialProps) {
        {
          warnWhen(instance.state.isDestroyed, createMemoryLeakWarning("setProps"));
        }
        if (instance.state.isDestroyed) {
          return;
        }
        invokeHook("onBeforeUpdate", [instance, partialProps]);
        removeListeners();
        var prevProps = instance.props;
        var nextProps = evaluateProps(reference, Object.assign({}, instance.props, {}, partialProps, {
          ignoreAttributes: true
        }));
        instance.props = nextProps;
        addListeners();
        if (prevProps.interactiveDebounce !== nextProps.interactiveDebounce) {
          cleanupInteractiveMouseListeners();
          debouncedOnMouseMove = debounce(onMouseMove, nextProps.interactiveDebounce);
        }
        if (prevProps.triggerTarget && !nextProps.triggerTarget) {
          normalizeToArray(prevProps.triggerTarget).forEach(function (node) {
            node.removeAttribute("aria-expanded");
          });
        } else if (nextProps.triggerTarget) {
          reference.removeAttribute("aria-expanded");
        }
        handleAriaExpandedAttribute();
        handleStyles();
        if (onUpdate) {
          onUpdate(prevProps, nextProps);
        }
        if (instance.popperInstance) {
          createPopperInstance();
          getNestedPopperTree().forEach(function (nestedPopper) {
            requestAnimationFrame(nestedPopper._tippy.popperInstance.forceUpdate);
          });
        }
        invokeHook("onAfterUpdate", [instance, partialProps]);
      }
      function setContent2(content) {
        instance.setProps({
          content
        });
      }
      function show() {
        {
          warnWhen(instance.state.isDestroyed, createMemoryLeakWarning("show"));
        }
        var isAlreadyVisible = instance.state.isVisible;
        var isDestroyed = instance.state.isDestroyed;
        var isDisabled = !instance.state.isEnabled;
        var isTouchAndTouchDisabled = currentInput.isTouch && !instance.props.touch;
        var duration = getValueAtIndexOrReturn(instance.props.duration, 0, defaultProps.duration);
        if (isAlreadyVisible || isDestroyed || isDisabled || isTouchAndTouchDisabled) {
          return;
        }
        if (getCurrentTarget().hasAttribute("disabled")) {
          return;
        }
        invokeHook("onShow", [instance], false);
        if (instance.props.onShow(instance) === false) {
          return;
        }
        instance.state.isVisible = true;
        if (getIsDefaultRenderFn()) {
          popper.style.visibility = "visible";
        }
        handleStyles();
        addDocumentPress();
        if (!instance.state.isMounted) {
          popper.style.transition = "none";
        }
        if (getIsDefaultRenderFn()) {
          var _getDefaultTemplateCh2 = getDefaultTemplateChildren(),
            box = _getDefaultTemplateCh2.box,
            content = _getDefaultTemplateCh2.content;
          setTransitionDuration([box, content], 0);
        }
        onFirstUpdate = function onFirstUpdate2() {
          var _instance$popperInsta2;
          if (!instance.state.isVisible || ignoreOnFirstUpdate) {
            return;
          }
          ignoreOnFirstUpdate = true;
          void popper.offsetHeight;
          popper.style.transition = instance.props.moveTransition;
          if (getIsDefaultRenderFn() && instance.props.animation) {
            var _getDefaultTemplateCh3 = getDefaultTemplateChildren(),
              _box = _getDefaultTemplateCh3.box,
              _content = _getDefaultTemplateCh3.content;
            setTransitionDuration([_box, _content], duration);
            setVisibilityState([_box, _content], "visible");
          }
          handleAriaContentAttribute();
          handleAriaExpandedAttribute();
          pushIfUnique(mountedInstances, instance);
          (_instance$popperInsta2 = instance.popperInstance) == null ? void 0 : _instance$popperInsta2.forceUpdate();
          instance.state.isMounted = true;
          invokeHook("onMount", [instance]);
          if (instance.props.animation && getIsDefaultRenderFn()) {
            onTransitionedIn(duration, function () {
              instance.state.isShown = true;
              invokeHook("onShown", [instance]);
            });
          }
        };
        mount();
      }
      function hide() {
        {
          warnWhen(instance.state.isDestroyed, createMemoryLeakWarning("hide"));
        }
        var isAlreadyHidden = !instance.state.isVisible;
        var isDestroyed = instance.state.isDestroyed;
        var isDisabled = !instance.state.isEnabled;
        var duration = getValueAtIndexOrReturn(instance.props.duration, 1, defaultProps.duration);
        if (isAlreadyHidden || isDestroyed || isDisabled) {
          return;
        }
        invokeHook("onHide", [instance], false);
        if (instance.props.onHide(instance) === false) {
          return;
        }
        instance.state.isVisible = false;
        instance.state.isShown = false;
        ignoreOnFirstUpdate = false;
        isVisibleFromClick = false;
        if (getIsDefaultRenderFn()) {
          popper.style.visibility = "hidden";
        }
        cleanupInteractiveMouseListeners();
        removeDocumentPress();
        handleStyles();
        if (getIsDefaultRenderFn()) {
          var _getDefaultTemplateCh4 = getDefaultTemplateChildren(),
            box = _getDefaultTemplateCh4.box,
            content = _getDefaultTemplateCh4.content;
          if (instance.props.animation) {
            setTransitionDuration([box, content], duration);
            setVisibilityState([box, content], "hidden");
          }
        }
        handleAriaContentAttribute();
        handleAriaExpandedAttribute();
        if (instance.props.animation) {
          if (getIsDefaultRenderFn()) {
            onTransitionedOut(duration, instance.unmount);
          }
        } else {
          instance.unmount();
        }
      }
      function hideWithInteractivity(event) {
        {
          warnWhen(instance.state.isDestroyed, createMemoryLeakWarning("hideWithInteractivity"));
        }
        getDocument().addEventListener("mousemove", debouncedOnMouseMove);
        pushIfUnique(mouseMoveListeners, debouncedOnMouseMove);
        debouncedOnMouseMove(event);
      }
      function unmount() {
        {
          warnWhen(instance.state.isDestroyed, createMemoryLeakWarning("unmount"));
        }
        if (instance.state.isVisible) {
          instance.hide();
        }
        if (!instance.state.isMounted) {
          return;
        }
        destroyPopperInstance();
        getNestedPopperTree().forEach(function (nestedPopper) {
          nestedPopper._tippy.unmount();
        });
        if (popper.parentNode) {
          popper.parentNode.removeChild(popper);
        }
        mountedInstances = mountedInstances.filter(function (i) {
          return i !== instance;
        });
        instance.state.isMounted = false;
        invokeHook("onHidden", [instance]);
      }
      function destroy() {
        {
          warnWhen(instance.state.isDestroyed, createMemoryLeakWarning("destroy"));
        }
        if (instance.state.isDestroyed) {
          return;
        }
        instance.clearDelayTimeouts();
        instance.unmount();
        removeListeners();
        delete reference._tippy;
        instance.state.isDestroyed = true;
        invokeHook("onDestroy", [instance]);
      }
    }
    function tippy2(targets, optionalProps) {
      if (optionalProps === void 0) {
        optionalProps = {};
      }
      var plugins = defaultProps.plugins.concat(optionalProps.plugins || []);
      {
        validateTargets(targets);
        validateProps(optionalProps, plugins);
      }
      bindGlobalEventListeners();
      var passedProps = Object.assign({}, optionalProps, {
        plugins
      });
      var elements = getArrayOfElements(targets);
      {
        var isSingleContentElement = isElement(passedProps.content);
        var isMoreThanOneReferenceElement = elements.length > 1;
        warnWhen(isSingleContentElement && isMoreThanOneReferenceElement, ["tippy() was passed an Element as the `content` prop, but more than", "one tippy instance was created by this invocation. This means the", "content element will only be appended to the last tippy instance.", "\n\n", "Instead, pass the .innerHTML of the element, or use a function that", "returns a cloned version of the element instead.", "\n\n", "1) content: element.innerHTML\n", "2) content: () => element.cloneNode(true)"].join(" "));
      }
      var instances = elements.reduce(function (acc, reference) {
        var instance = reference && createTippy(reference, passedProps);
        if (instance) {
          acc.push(instance);
        }
        return acc;
      }, []);
      return isElement(targets) ? instances[0] : instances;
    }
    tippy2.defaultProps = defaultProps;
    tippy2.setDefaultProps = setDefaultProps;
    tippy2.currentInput = currentInput;
    var hideAll = function hideAll2(_temp) {
      var _ref = _temp === void 0 ? {} : _temp,
        excludedReferenceOrInstance = _ref.exclude,
        duration = _ref.duration;
      mountedInstances.forEach(function (instance) {
        var isExcluded = false;
        if (excludedReferenceOrInstance) {
          isExcluded = isReferenceElement(excludedReferenceOrInstance) ? instance.reference === excludedReferenceOrInstance : instance.popper === excludedReferenceOrInstance.popper;
        }
        if (!isExcluded) {
          var originalDuration = instance.props.duration;
          instance.setProps({
            duration
          });
          instance.hide();
          if (!instance.state.isDestroyed) {
            instance.setProps({
              duration: originalDuration
            });
          }
        }
      });
    };
    var applyStylesModifier = Object.assign({}, core.applyStyles, {
      effect: function effect(_ref) {
        var state = _ref.state;
        var initialStyles = {
          popper: {
            position: state.options.strategy,
            left: "0",
            top: "0",
            margin: "0"
          },
          arrow: {
            position: "absolute"
          },
          reference: {}
        };
        Object.assign(state.elements.popper.style, initialStyles.popper);
        state.styles = initialStyles;
        if (state.elements.arrow) {
          Object.assign(state.elements.arrow.style, initialStyles.arrow);
        }
      }
    });
    var createSingleton = function createSingleton2(tippyInstances, optionalProps) {
      var _optionalProps$popper;
      if (optionalProps === void 0) {
        optionalProps = {};
      }
      {
        errorWhen(!Array.isArray(tippyInstances), ["The first argument passed to createSingleton() must be an array of", "tippy instances. The passed value was", String(tippyInstances)].join(" "));
      }
      var individualInstances = tippyInstances;
      var references = [];
      var currentTarget;
      var overrides = optionalProps.overrides;
      var interceptSetPropsCleanups = [];
      var shownOnCreate = false;
      function setReferences() {
        references = individualInstances.map(function (instance) {
          return instance.reference;
        });
      }
      function enableInstances(isEnabled) {
        individualInstances.forEach(function (instance) {
          if (isEnabled) {
            instance.enable();
          } else {
            instance.disable();
          }
        });
      }
      function interceptSetProps(singleton2) {
        return individualInstances.map(function (instance) {
          var originalSetProps2 = instance.setProps;
          instance.setProps = function (props) {
            originalSetProps2(props);
            if (instance.reference === currentTarget) {
              singleton2.setProps(props);
            }
          };
          return function () {
            instance.setProps = originalSetProps2;
          };
        });
      }
      function prepareInstance(singleton2, target) {
        var index = references.indexOf(target);
        if (target === currentTarget) {
          return;
        }
        currentTarget = target;
        var overrideProps = (overrides || []).concat("content").reduce(function (acc, prop) {
          acc[prop] = individualInstances[index].props[prop];
          return acc;
        }, {});
        singleton2.setProps(Object.assign({}, overrideProps, {
          getReferenceClientRect: typeof overrideProps.getReferenceClientRect === "function" ? overrideProps.getReferenceClientRect : function () {
            return target.getBoundingClientRect();
          }
        }));
      }
      enableInstances(false);
      setReferences();
      var plugin = {
        fn: function fn() {
          return {
            onDestroy: function onDestroy() {
              enableInstances(true);
            },
            onHidden: function onHidden() {
              currentTarget = null;
            },
            onClickOutside: function onClickOutside(instance) {
              if (instance.props.showOnCreate && !shownOnCreate) {
                shownOnCreate = true;
                currentTarget = null;
              }
            },
            onShow: function onShow(instance) {
              if (instance.props.showOnCreate && !shownOnCreate) {
                shownOnCreate = true;
                prepareInstance(instance, references[0]);
              }
            },
            onTrigger: function onTrigger(instance, event) {
              prepareInstance(instance, event.currentTarget);
            }
          };
        }
      };
      var singleton = tippy2(div(), Object.assign({}, removeProperties(optionalProps, ["overrides"]), {
        plugins: [plugin].concat(optionalProps.plugins || []),
        triggerTarget: references,
        popperOptions: Object.assign({}, optionalProps.popperOptions, {
          modifiers: [].concat(((_optionalProps$popper = optionalProps.popperOptions) == null ? void 0 : _optionalProps$popper.modifiers) || [], [applyStylesModifier])
        })
      }));
      var originalShow = singleton.show;
      singleton.show = function (target) {
        originalShow();
        if (!currentTarget && target == null) {
          return prepareInstance(singleton, references[0]);
        }
        if (currentTarget && target == null) {
          return;
        }
        if (typeof target === "number") {
          return references[target] && prepareInstance(singleton, references[target]);
        }
        if (individualInstances.includes(target)) {
          var ref = target.reference;
          return prepareInstance(singleton, ref);
        }
        if (references.includes(target)) {
          return prepareInstance(singleton, target);
        }
      };
      singleton.showNext = function () {
        var first = references[0];
        if (!currentTarget) {
          return singleton.show(0);
        }
        var index = references.indexOf(currentTarget);
        singleton.show(references[index + 1] || first);
      };
      singleton.showPrevious = function () {
        var last = references[references.length - 1];
        if (!currentTarget) {
          return singleton.show(last);
        }
        var index = references.indexOf(currentTarget);
        var target = references[index - 1] || last;
        singleton.show(target);
      };
      var originalSetProps = singleton.setProps;
      singleton.setProps = function (props) {
        overrides = props.overrides || overrides;
        originalSetProps(props);
      };
      singleton.setInstances = function (nextInstances) {
        enableInstances(true);
        interceptSetPropsCleanups.forEach(function (fn) {
          return fn();
        });
        individualInstances = nextInstances;
        enableInstances(false);
        setReferences();
        interceptSetProps(singleton);
        singleton.setProps({
          triggerTarget: references
        });
      };
      interceptSetPropsCleanups = interceptSetProps(singleton);
      return singleton;
    };
    var BUBBLING_EVENTS_MAP = {
      mouseover: "mouseenter",
      focusin: "focus",
      click: "click"
    };
    function delegate(targets, props) {
      {
        errorWhen(!(props && props.target), ["You must specity a `target` prop indicating a CSS selector string matching", "the target elements that should receive a tippy."].join(" "));
      }
      var listeners = [];
      var childTippyInstances = [];
      var disabled = false;
      var target = props.target;
      var nativeProps = removeProperties(props, ["target"]);
      var parentProps = Object.assign({}, nativeProps, {
        trigger: "manual",
        touch: false
      });
      var childProps = Object.assign({}, nativeProps, {
        showOnCreate: true
      });
      var returnValue = tippy2(targets, parentProps);
      var normalizedReturnValue = normalizeToArray(returnValue);
      function onTrigger(event) {
        if (!event.target || disabled) {
          return;
        }
        var targetNode = event.target.closest(target);
        if (!targetNode) {
          return;
        }
        var trigger = targetNode.getAttribute("data-tippy-trigger") || props.trigger || defaultProps.trigger;
        if (targetNode._tippy) {
          return;
        }
        if (event.type === "touchstart" && typeof childProps.touch === "boolean") {
          return;
        }
        if (event.type !== "touchstart" && trigger.indexOf(BUBBLING_EVENTS_MAP[event.type]) < 0) {
          return;
        }
        var instance = tippy2(targetNode, childProps);
        if (instance) {
          childTippyInstances = childTippyInstances.concat(instance);
        }
      }
      function on(node, eventType, handler, options) {
        if (options === void 0) {
          options = false;
        }
        node.addEventListener(eventType, handler, options);
        listeners.push({
          node,
          eventType,
          handler,
          options
        });
      }
      function addEventListeners(instance) {
        var reference = instance.reference;
        on(reference, "touchstart", onTrigger, TOUCH_OPTIONS);
        on(reference, "mouseover", onTrigger);
        on(reference, "focusin", onTrigger);
        on(reference, "click", onTrigger);
      }
      function removeEventListeners() {
        listeners.forEach(function (_ref) {
          var node = _ref.node,
            eventType = _ref.eventType,
            handler = _ref.handler,
            options = _ref.options;
          node.removeEventListener(eventType, handler, options);
        });
        listeners = [];
      }
      function applyMutations(instance) {
        var originalDestroy = instance.destroy;
        var originalEnable = instance.enable;
        var originalDisable = instance.disable;
        instance.destroy = function (shouldDestroyChildInstances) {
          if (shouldDestroyChildInstances === void 0) {
            shouldDestroyChildInstances = true;
          }
          if (shouldDestroyChildInstances) {
            childTippyInstances.forEach(function (instance2) {
              instance2.destroy();
            });
          }
          childTippyInstances = [];
          removeEventListeners();
          originalDestroy();
        };
        instance.enable = function () {
          originalEnable();
          childTippyInstances.forEach(function (instance2) {
            return instance2.enable();
          });
          disabled = false;
        };
        instance.disable = function () {
          originalDisable();
          childTippyInstances.forEach(function (instance2) {
            return instance2.disable();
          });
          disabled = true;
        };
        addEventListeners(instance);
      }
      normalizedReturnValue.forEach(applyMutations);
      return returnValue;
    }
    var animateFill = {
      name: "animateFill",
      defaultValue: false,
      fn: function fn(instance) {
        var _instance$props$rende;
        if (!((_instance$props$rende = instance.props.render) == null ? void 0 : _instance$props$rende.$$tippy)) {
          {
            errorWhen(instance.props.animateFill, "The `animateFill` plugin requires the default render function.");
          }
          return {};
        }
        var _getChildren = getChildren(instance.popper),
          box = _getChildren.box,
          content = _getChildren.content;
        var backdrop = instance.props.animateFill ? createBackdropElement() : null;
        return {
          onCreate: function onCreate() {
            if (backdrop) {
              box.insertBefore(backdrop, box.firstElementChild);
              box.setAttribute("data-animatefill", "");
              box.style.overflow = "hidden";
              instance.setProps({
                arrow: false,
                animation: "shift-away"
              });
            }
          },
          onMount: function onMount() {
            if (backdrop) {
              var transitionDuration = box.style.transitionDuration;
              var duration = Number(transitionDuration.replace("ms", ""));
              content.style.transitionDelay = Math.round(duration / 10) + "ms";
              backdrop.style.transitionDuration = transitionDuration;
              setVisibilityState([backdrop], "visible");
            }
          },
          onShow: function onShow() {
            if (backdrop) {
              backdrop.style.transitionDuration = "0ms";
            }
          },
          onHide: function onHide() {
            if (backdrop) {
              setVisibilityState([backdrop], "hidden");
            }
          }
        };
      }
    };
    function createBackdropElement() {
      var backdrop = div();
      backdrop.className = BACKDROP_CLASS;
      setVisibilityState([backdrop], "hidden");
      return backdrop;
    }
    var mouseCoords = {
      clientX: 0,
      clientY: 0
    };
    var activeInstances = [];
    function storeMouseCoords(_ref) {
      var clientX = _ref.clientX,
        clientY = _ref.clientY;
      mouseCoords = {
        clientX,
        clientY
      };
    }
    function addMouseCoordsListener(doc) {
      doc.addEventListener("mousemove", storeMouseCoords);
    }
    function removeMouseCoordsListener(doc) {
      doc.removeEventListener("mousemove", storeMouseCoords);
    }
    var followCursor2 = {
      name: "followCursor",
      defaultValue: false,
      fn: function fn(instance) {
        var reference = instance.reference;
        var doc = getOwnerDocument(instance.props.triggerTarget || reference);
        var isInternalUpdate = false;
        var wasFocusEvent = false;
        var isUnmounted = true;
        var prevProps = instance.props;
        function getIsInitialBehavior() {
          return instance.props.followCursor === "initial" && instance.state.isVisible;
        }
        function addListener() {
          doc.addEventListener("mousemove", onMouseMove);
        }
        function removeListener() {
          doc.removeEventListener("mousemove", onMouseMove);
        }
        function unsetGetReferenceClientRect() {
          isInternalUpdate = true;
          instance.setProps({
            getReferenceClientRect: null
          });
          isInternalUpdate = false;
        }
        function onMouseMove(event) {
          var isCursorOverReference = event.target ? reference.contains(event.target) : true;
          var followCursor3 = instance.props.followCursor;
          var clientX = event.clientX,
            clientY = event.clientY;
          var rect = reference.getBoundingClientRect();
          var relativeX = clientX - rect.left;
          var relativeY = clientY - rect.top;
          if (isCursorOverReference || !instance.props.interactive) {
            instance.setProps({
              getReferenceClientRect: function getReferenceClientRect() {
                var rect2 = reference.getBoundingClientRect();
                var x = clientX;
                var y = clientY;
                if (followCursor3 === "initial") {
                  x = rect2.left + relativeX;
                  y = rect2.top + relativeY;
                }
                var top = followCursor3 === "horizontal" ? rect2.top : y;
                var right = followCursor3 === "vertical" ? rect2.right : x;
                var bottom = followCursor3 === "horizontal" ? rect2.bottom : y;
                var left = followCursor3 === "vertical" ? rect2.left : x;
                return {
                  width: right - left,
                  height: bottom - top,
                  top,
                  right,
                  bottom,
                  left
                };
              }
            });
          }
        }
        function create() {
          if (instance.props.followCursor) {
            activeInstances.push({
              instance,
              doc
            });
            addMouseCoordsListener(doc);
          }
        }
        function destroy() {
          activeInstances = activeInstances.filter(function (data) {
            return data.instance !== instance;
          });
          if (activeInstances.filter(function (data) {
            return data.doc === doc;
          }).length === 0) {
            removeMouseCoordsListener(doc);
          }
        }
        return {
          onCreate: create,
          onDestroy: destroy,
          onBeforeUpdate: function onBeforeUpdate() {
            prevProps = instance.props;
          },
          onAfterUpdate: function onAfterUpdate(_, _ref2) {
            var followCursor3 = _ref2.followCursor;
            if (isInternalUpdate) {
              return;
            }
            if (followCursor3 !== void 0 && prevProps.followCursor !== followCursor3) {
              destroy();
              if (followCursor3) {
                create();
                if (instance.state.isMounted && !wasFocusEvent && !getIsInitialBehavior()) {
                  addListener();
                }
              } else {
                removeListener();
                unsetGetReferenceClientRect();
              }
            }
          },
          onMount: function onMount() {
            if (instance.props.followCursor && !wasFocusEvent) {
              if (isUnmounted) {
                onMouseMove(mouseCoords);
                isUnmounted = false;
              }
              if (!getIsInitialBehavior()) {
                addListener();
              }
            }
          },
          onTrigger: function onTrigger(_, event) {
            if (isMouseEvent(event)) {
              mouseCoords = {
                clientX: event.clientX,
                clientY: event.clientY
              };
            }
            wasFocusEvent = event.type === "focus";
          },
          onHidden: function onHidden() {
            if (instance.props.followCursor) {
              unsetGetReferenceClientRect();
              removeListener();
              isUnmounted = true;
            }
          }
        };
      }
    };
    function getProps(props, modifier) {
      var _props$popperOptions;
      return {
        popperOptions: Object.assign({}, props.popperOptions, {
          modifiers: [].concat((((_props$popperOptions = props.popperOptions) == null ? void 0 : _props$popperOptions.modifiers) || []).filter(function (_ref) {
            var name = _ref.name;
            return name !== modifier.name;
          }), [modifier])
        })
      };
    }
    var inlinePositioning = {
      name: "inlinePositioning",
      defaultValue: false,
      fn: function fn(instance) {
        var reference = instance.reference;
        function isEnabled() {
          return !!instance.props.inlinePositioning;
        }
        var placement;
        var cursorRectIndex = -1;
        var isInternalUpdate = false;
        var modifier = {
          name: "tippyInlinePositioning",
          enabled: true,
          phase: "afterWrite",
          fn: function fn2(_ref2) {
            var state = _ref2.state;
            if (isEnabled()) {
              if (placement !== state.placement) {
                instance.setProps({
                  getReferenceClientRect: function getReferenceClientRect() {
                    return _getReferenceClientRect(state.placement);
                  }
                });
              }
              placement = state.placement;
            }
          }
        };
        function _getReferenceClientRect(placement2) {
          return getInlineBoundingClientRect(getBasePlacement(placement2), reference.getBoundingClientRect(), arrayFrom(reference.getClientRects()), cursorRectIndex);
        }
        function setInternalProps(partialProps) {
          isInternalUpdate = true;
          instance.setProps(partialProps);
          isInternalUpdate = false;
        }
        function addModifier() {
          if (!isInternalUpdate) {
            setInternalProps(getProps(instance.props, modifier));
          }
        }
        return {
          onCreate: addModifier,
          onAfterUpdate: addModifier,
          onTrigger: function onTrigger(_, event) {
            if (isMouseEvent(event)) {
              var rects = arrayFrom(instance.reference.getClientRects());
              var cursorRect = rects.find(function (rect) {
                return rect.left - 2 <= event.clientX && rect.right + 2 >= event.clientX && rect.top - 2 <= event.clientY && rect.bottom + 2 >= event.clientY;
              });
              cursorRectIndex = rects.indexOf(cursorRect);
            }
          },
          onUntrigger: function onUntrigger() {
            cursorRectIndex = -1;
          }
        };
      }
    };
    function getInlineBoundingClientRect(currentBasePlacement, boundingRect, clientRects, cursorRectIndex) {
      if (clientRects.length < 2 || currentBasePlacement === null) {
        return boundingRect;
      }
      if (clientRects.length === 2 && cursorRectIndex >= 0 && clientRects[0].left > clientRects[1].right) {
        return clientRects[cursorRectIndex] || boundingRect;
      }
      switch (currentBasePlacement) {
        case "top":
        case "bottom":
          {
            var firstRect = clientRects[0];
            var lastRect = clientRects[clientRects.length - 1];
            var isTop = currentBasePlacement === "top";
            var top = firstRect.top;
            var bottom = lastRect.bottom;
            var left = isTop ? firstRect.left : lastRect.left;
            var right = isTop ? firstRect.right : lastRect.right;
            var width = right - left;
            var height = bottom - top;
            return {
              top,
              bottom,
              left,
              right,
              width,
              height
            };
          }
        case "left":
        case "right":
          {
            var minLeft = Math.min.apply(Math, clientRects.map(function (rects) {
              return rects.left;
            }));
            var maxRight = Math.max.apply(Math, clientRects.map(function (rects) {
              return rects.right;
            }));
            var measureRects = clientRects.filter(function (rect) {
              return currentBasePlacement === "left" ? rect.left === minLeft : rect.right === maxRight;
            });
            var _top = measureRects[0].top;
            var _bottom = measureRects[measureRects.length - 1].bottom;
            var _left = minLeft;
            var _right = maxRight;
            var _width = _right - _left;
            var _height = _bottom - _top;
            return {
              top: _top,
              bottom: _bottom,
              left: _left,
              right: _right,
              width: _width,
              height: _height
            };
          }
        default:
          {
            return boundingRect;
          }
      }
    }
    var sticky = {
      name: "sticky",
      defaultValue: false,
      fn: function fn(instance) {
        var reference = instance.reference,
          popper = instance.popper;
        function getReference() {
          return instance.popperInstance ? instance.popperInstance.state.elements.reference : reference;
        }
        function shouldCheck(value) {
          return instance.props.sticky === true || instance.props.sticky === value;
        }
        var prevRefRect = null;
        var prevPopRect = null;
        function updatePosition() {
          var currentRefRect = shouldCheck("reference") ? getReference().getBoundingClientRect() : null;
          var currentPopRect = shouldCheck("popper") ? popper.getBoundingClientRect() : null;
          if (currentRefRect && areRectsDifferent(prevRefRect, currentRefRect) || currentPopRect && areRectsDifferent(prevPopRect, currentPopRect)) {
            if (instance.popperInstance) {
              instance.popperInstance.update();
            }
          }
          prevRefRect = currentRefRect;
          prevPopRect = currentPopRect;
          if (instance.state.isMounted) {
            requestAnimationFrame(updatePosition);
          }
        }
        return {
          onMount: function onMount() {
            if (instance.props.sticky) {
              updatePosition();
            }
          }
        };
      }
    };
    function areRectsDifferent(rectA, rectB) {
      if (rectA && rectB) {
        return rectA.top !== rectB.top || rectA.right !== rectB.right || rectA.bottom !== rectB.bottom || rectA.left !== rectB.left;
      }
      return true;
    }
    tippy2.setDefaultProps({
      render
    });
    exports.animateFill = animateFill;
    exports.createSingleton = createSingleton;
    exports.default = tippy2;
    exports.delegate = delegate;
    exports.followCursor = followCursor2;
    exports.hideAll = hideAll;
    exports.inlinePositioning = inlinePositioning;
    exports.roundArrow = ROUND_ARROW;
    exports.sticky = sticky;
  });

  // src/index.js
  var import_tippy2 = __toModule(require_tippy_cjs());

  // src/buildConfigFromModifiers.js
  var import_tippy = __toModule(require_tippy_cjs());
  var buildConfigFromModifiers = modifiers => {
    const config = {
      plugins: []
    };
    const getModifierArgument = modifier => {
      return modifiers[modifiers.indexOf(modifier) + 1];
    };
    if (modifiers.includes("animation")) {
      config.animation = getModifierArgument("animation");
    }
    if (modifiers.includes("duration")) {
      config.duration = parseInt(getModifierArgument("duration"));
    }
    if (modifiers.includes("delay")) {
      const delay = getModifierArgument("delay");
      config.delay = delay.includes("-") ? delay.split("-").map(n => parseInt(n)) : parseInt(delay);
    }
    if (modifiers.includes("cursor")) {
      config.plugins.push(import_tippy.followCursor);
      const next = getModifierArgument("cursor");
      if (["x", "initial"].includes(next)) {
        config.followCursor = next === "x" ? "horizontal" : "initial";
      } else {
        config.followCursor = true;
      }
    }
    if (modifiers.includes("on")) {
      config.trigger = getModifierArgument("on");
    }
    if (modifiers.includes("arrowless")) {
      config.arrow = false;
    }
    if (modifiers.includes("html")) {
      config.allowHTML = true;
    }
    if (modifiers.includes("interactive")) {
      config.interactive = true;
    }
    if (modifiers.includes("border") && config.interactive) {
      config.interactiveBorder = parseInt(getModifierArgument("border"));
    }
    if (modifiers.includes("debounce") && config.interactive) {
      config.interactiveDebounce = parseInt(getModifierArgument("debounce"));
    }
    if (modifiers.includes("max-width")) {
      config.maxWidth = parseInt(getModifierArgument("max-width"));
    }
    if (modifiers.includes("theme")) {
      config.theme = getModifierArgument("theme");
    }
    if (modifiers.includes("placement")) {
      config.placement = getModifierArgument("placement");
    }
    const popperOptions = {};
    if (modifiers.includes("no-flip")) {
      popperOptions.modifiers ||= [];
      popperOptions.modifiers.push({
        name: "flip",
        enabled: false
      });
    }
    config.popperOptions = popperOptions;
    return config;
  };

  // src/index.js
  function Tooltip(Alpine) {
    Alpine.magic("tooltip", el => {
      return (content, config = {}) => {
        const timeout = config.timeout;
        delete config.timeout;
        const instance = (0, import_tippy2.default)(el, {
          content,
          trigger: "manual",
          ...config
        });
        instance.show();
        setTimeout(() => {
          instance.hide();
          setTimeout(() => instance.destroy(), config.duration || 300);
        }, timeout || 2e3);
      };
    });
    Alpine.directive("tooltip", (el, {
      modifiers,
      expression
    }, {
      evaluateLater,
      effect
    }) => {
      const config = modifiers.length > 0 ? buildConfigFromModifiers(modifiers) : {};
      if (!el.__x_tippy) {
        el.__x_tippy = (0, import_tippy2.default)(el, config);
      }
      const enableTooltip = () => el.__x_tippy.enable();
      const disableTooltip = () => el.__x_tippy.disable();
      const setupTooltip = content => {
        if (!content) {
          disableTooltip();
        } else {
          enableTooltip();
          el.__x_tippy.setContent(content);
        }
      };
      if (modifiers.includes("raw")) {
        setupTooltip(expression);
      } else {
        const getContent = evaluateLater(expression);
        effect(() => {
          getContent(content => {
            if (typeof content === "object") {
              el.__x_tippy.setProps(content);
              enableTooltip();
            } else {
              setupTooltip(content);
            }
          });
        });
      }
    });
  }
  Tooltip.defaultProps = props => {
    import_tippy2.default.setDefaultProps(props);
    return Tooltip;
  };
  var src_default = Tooltip;

  // builds/module.js
  var module_default = src_default;

  function ownKeys(object, enumerableOnly) {
    var keys = Object.keys(object);
    if (Object.getOwnPropertySymbols) {
      var symbols = Object.getOwnPropertySymbols(object);
      enumerableOnly && (symbols = symbols.filter(function (sym) {
        return Object.getOwnPropertyDescriptor(object, sym).enumerable;
      })), keys.push.apply(keys, symbols);
    }
    return keys;
  }
  function _objectSpread2(target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = null != arguments[i] ? arguments[i] : {};
      i % 2 ? ownKeys(Object(source), !0).forEach(function (key) {
        _defineProperty(target, key, source[key]);
      }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) {
        Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
      });
    }
    return target;
  }
  function _regeneratorRuntime() {
    _regeneratorRuntime = function () {
      return exports;
    };
    var exports = {},
      Op = Object.prototype,
      hasOwn = Op.hasOwnProperty,
      defineProperty = Object.defineProperty || function (obj, key, desc) {
        obj[key] = desc.value;
      },
      $Symbol = "function" == typeof Symbol ? Symbol : {},
      iteratorSymbol = $Symbol.iterator || "@@iterator",
      asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator",
      toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";
    function define(obj, key, value) {
      return Object.defineProperty(obj, key, {
        value: value,
        enumerable: !0,
        configurable: !0,
        writable: !0
      }), obj[key];
    }
    try {
      define({}, "");
    } catch (err) {
      define = function (obj, key, value) {
        return obj[key] = value;
      };
    }
    function wrap(innerFn, outerFn, self, tryLocsList) {
      var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator,
        generator = Object.create(protoGenerator.prototype),
        context = new Context(tryLocsList || []);
      return defineProperty(generator, "_invoke", {
        value: makeInvokeMethod(innerFn, self, context)
      }), generator;
    }
    function tryCatch(fn, obj, arg) {
      try {
        return {
          type: "normal",
          arg: fn.call(obj, arg)
        };
      } catch (err) {
        return {
          type: "throw",
          arg: err
        };
      }
    }
    exports.wrap = wrap;
    var ContinueSentinel = {};
    function Generator() {}
    function GeneratorFunction() {}
    function GeneratorFunctionPrototype() {}
    var IteratorPrototype = {};
    define(IteratorPrototype, iteratorSymbol, function () {
      return this;
    });
    var getProto = Object.getPrototypeOf,
      NativeIteratorPrototype = getProto && getProto(getProto(values([])));
    NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype);
    var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype);
    function defineIteratorMethods(prototype) {
      ["next", "throw", "return"].forEach(function (method) {
        define(prototype, method, function (arg) {
          return this._invoke(method, arg);
        });
      });
    }
    function AsyncIterator(generator, PromiseImpl) {
      function invoke(method, arg, resolve, reject) {
        var record = tryCatch(generator[method], generator, arg);
        if ("throw" !== record.type) {
          var result = record.arg,
            value = result.value;
          return value && "object" == typeof value && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) {
            invoke("next", value, resolve, reject);
          }, function (err) {
            invoke("throw", err, resolve, reject);
          }) : PromiseImpl.resolve(value).then(function (unwrapped) {
            result.value = unwrapped, resolve(result);
          }, function (error) {
            return invoke("throw", error, resolve, reject);
          });
        }
        reject(record.arg);
      }
      var previousPromise;
      defineProperty(this, "_invoke", {
        value: function (method, arg) {
          function callInvokeWithMethodAndArg() {
            return new PromiseImpl(function (resolve, reject) {
              invoke(method, arg, resolve, reject);
            });
          }
          return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg();
        }
      });
    }
    function makeInvokeMethod(innerFn, self, context) {
      var state = "suspendedStart";
      return function (method, arg) {
        if ("executing" === state) throw new Error("Generator is already running");
        if ("completed" === state) {
          if ("throw" === method) throw arg;
          return doneResult();
        }
        for (context.method = method, context.arg = arg;;) {
          var delegate = context.delegate;
          if (delegate) {
            var delegateResult = maybeInvokeDelegate(delegate, context);
            if (delegateResult) {
              if (delegateResult === ContinueSentinel) continue;
              return delegateResult;
            }
          }
          if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) {
            if ("suspendedStart" === state) throw state = "completed", context.arg;
            context.dispatchException(context.arg);
          } else "return" === context.method && context.abrupt("return", context.arg);
          state = "executing";
          var record = tryCatch(innerFn, self, context);
          if ("normal" === record.type) {
            if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue;
            return {
              value: record.arg,
              done: context.done
            };
          }
          "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg);
        }
      };
    }
    function maybeInvokeDelegate(delegate, context) {
      var methodName = context.method,
        method = delegate.iterator[methodName];
      if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator.return && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel;
      var record = tryCatch(method, delegate.iterator, context.arg);
      if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel;
      var info = record.arg;
      return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel);
    }
    function pushTryEntry(locs) {
      var entry = {
        tryLoc: locs[0]
      };
      1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry);
    }
    function resetTryEntry(entry) {
      var record = entry.completion || {};
      record.type = "normal", delete record.arg, entry.completion = record;
    }
    function Context(tryLocsList) {
      this.tryEntries = [{
        tryLoc: "root"
      }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0);
    }
    function values(iterable) {
      if (iterable) {
        var iteratorMethod = iterable[iteratorSymbol];
        if (iteratorMethod) return iteratorMethod.call(iterable);
        if ("function" == typeof iterable.next) return iterable;
        if (!isNaN(iterable.length)) {
          var i = -1,
            next = function next() {
              for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next;
              return next.value = undefined, next.done = !0, next;
            };
          return next.next = next;
        }
      }
      return {
        next: doneResult
      };
    }
    function doneResult() {
      return {
        value: undefined,
        done: !0
      };
    }
    return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", {
      value: GeneratorFunctionPrototype,
      configurable: !0
    }), defineProperty(GeneratorFunctionPrototype, "constructor", {
      value: GeneratorFunction,
      configurable: !0
    }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) {
      var ctor = "function" == typeof genFun && genFun.constructor;
      return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name));
    }, exports.mark = function (genFun) {
      return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun;
    }, exports.awrap = function (arg) {
      return {
        __await: arg
      };
    }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () {
      return this;
    }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) {
      void 0 === PromiseImpl && (PromiseImpl = Promise);
      var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl);
      return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) {
        return result.done ? result.value : iter.next();
      });
    }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () {
      return this;
    }), define(Gp, "toString", function () {
      return "[object Generator]";
    }), exports.keys = function (val) {
      var object = Object(val),
        keys = [];
      for (var key in object) keys.push(key);
      return keys.reverse(), function next() {
        for (; keys.length;) {
          var key = keys.pop();
          if (key in object) return next.value = key, next.done = !1, next;
        }
        return next.done = !0, next;
      };
    }, exports.values = values, Context.prototype = {
      constructor: Context,
      reset: function (skipTempReset) {
        if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined);
      },
      stop: function () {
        this.done = !0;
        var rootRecord = this.tryEntries[0].completion;
        if ("throw" === rootRecord.type) throw rootRecord.arg;
        return this.rval;
      },
      dispatchException: function (exception) {
        if (this.done) throw exception;
        var context = this;
        function handle(loc, caught) {
          return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught;
        }
        for (var i = this.tryEntries.length - 1; i >= 0; --i) {
          var entry = this.tryEntries[i],
            record = entry.completion;
          if ("root" === entry.tryLoc) return handle("end");
          if (entry.tryLoc <= this.prev) {
            var hasCatch = hasOwn.call(entry, "catchLoc"),
              hasFinally = hasOwn.call(entry, "finallyLoc");
            if (hasCatch && hasFinally) {
              if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
              if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
            } else if (hasCatch) {
              if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
            } else {
              if (!hasFinally) throw new Error("try statement without catch or finally");
              if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
            }
          }
        }
      },
      abrupt: function (type, arg) {
        for (var i = this.tryEntries.length - 1; i >= 0; --i) {
          var entry = this.tryEntries[i];
          if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) {
            var finallyEntry = entry;
            break;
          }
        }
        finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null);
        var record = finallyEntry ? finallyEntry.completion : {};
        return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record);
      },
      complete: function (record, afterLoc) {
        if ("throw" === record.type) throw record.arg;
        return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel;
      },
      finish: function (finallyLoc) {
        for (var i = this.tryEntries.length - 1; i >= 0; --i) {
          var entry = this.tryEntries[i];
          if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel;
        }
      },
      catch: function (tryLoc) {
        for (var i = this.tryEntries.length - 1; i >= 0; --i) {
          var entry = this.tryEntries[i];
          if (entry.tryLoc === tryLoc) {
            var record = entry.completion;
            if ("throw" === record.type) {
              var thrown = record.arg;
              resetTryEntry(entry);
            }
            return thrown;
          }
        }
        throw new Error("illegal catch attempt");
      },
      delegateYield: function (iterable, resultName, nextLoc) {
        return this.delegate = {
          iterator: values(iterable),
          resultName: resultName,
          nextLoc: nextLoc
        }, "next" === this.method && (this.arg = undefined), ContinueSentinel;
      }
    }, exports;
  }
  function _typeof(obj) {
    "@babel/helpers - typeof";

    return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
      return typeof obj;
    } : function (obj) {
      return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    }, _typeof(obj);
  }
  function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
    try {
      var info = gen[key](arg);
      var value = info.value;
    } catch (error) {
      reject(error);
      return;
    }
    if (info.done) {
      resolve(value);
    } else {
      Promise.resolve(value).then(_next, _throw);
    }
  }
  function _asyncToGenerator(fn) {
    return function () {
      var self = this,
        args = arguments;
      return new Promise(function (resolve, reject) {
        var gen = fn.apply(self, args);
        function _next(value) {
          asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
        }
        function _throw(err) {
          asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
        }
        _next(undefined);
      });
    };
  }
  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }
  function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor);
    }
  }
  function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    Object.defineProperty(Constructor, "prototype", {
      writable: false
    });
    return Constructor;
  }
  function _defineProperty(obj, key, value) {
    key = _toPropertyKey(key);
    if (key in obj) {
      Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
      });
    } else {
      obj[key] = value;
    }
    return obj;
  }
  function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) {
      throw new TypeError("Super expression must either be null or a function");
    }
    subClass.prototype = Object.create(superClass && superClass.prototype, {
      constructor: {
        value: subClass,
        writable: true,
        configurable: true
      }
    });
    Object.defineProperty(subClass, "prototype", {
      writable: false
    });
    if (superClass) _setPrototypeOf(subClass, superClass);
  }
  function _getPrototypeOf(o) {
    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) {
      return o.__proto__ || Object.getPrototypeOf(o);
    };
    return _getPrototypeOf(o);
  }
  function _setPrototypeOf(o, p) {
    _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) {
      o.__proto__ = p;
      return o;
    };
    return _setPrototypeOf(o, p);
  }
  function _isNativeReflectConstruct() {
    if (typeof Reflect === "undefined" || !Reflect.construct) return false;
    if (Reflect.construct.sham) return false;
    if (typeof Proxy === "function") return true;
    try {
      Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {}));
      return true;
    } catch (e) {
      return false;
    }
  }
  function _construct(Parent, args, Class) {
    if (_isNativeReflectConstruct()) {
      _construct = Reflect.construct.bind();
    } else {
      _construct = function _construct(Parent, args, Class) {
        var a = [null];
        a.push.apply(a, args);
        var Constructor = Function.bind.apply(Parent, a);
        var instance = new Constructor();
        if (Class) _setPrototypeOf(instance, Class.prototype);
        return instance;
      };
    }
    return _construct.apply(null, arguments);
  }
  function _isNativeFunction(fn) {
    return Function.toString.call(fn).indexOf("[native code]") !== -1;
  }
  function _wrapNativeSuper(Class) {
    var _cache = typeof Map === "function" ? new Map() : undefined;
    _wrapNativeSuper = function _wrapNativeSuper(Class) {
      if (Class === null || !_isNativeFunction(Class)) return Class;
      if (typeof Class !== "function") {
        throw new TypeError("Super expression must either be null or a function");
      }
      if (typeof _cache !== "undefined") {
        if (_cache.has(Class)) return _cache.get(Class);
        _cache.set(Class, Wrapper);
      }
      function Wrapper() {
        return _construct(Class, arguments, _getPrototypeOf(this).constructor);
      }
      Wrapper.prototype = Object.create(Class.prototype, {
        constructor: {
          value: Wrapper,
          enumerable: false,
          writable: true,
          configurable: true
        }
      });
      return _setPrototypeOf(Wrapper, Class);
    };
    return _wrapNativeSuper(Class);
  }
  function _assertThisInitialized(self) {
    if (self === void 0) {
      throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    }
    return self;
  }
  function _possibleConstructorReturn(self, call) {
    if (call && (typeof call === "object" || typeof call === "function")) {
      return call;
    } else if (call !== void 0) {
      throw new TypeError("Derived constructors may only return object or undefined");
    }
    return _assertThisInitialized(self);
  }
  function _createSuper(Derived) {
    var hasNativeReflectConstruct = _isNativeReflectConstruct();
    return function _createSuperInternal() {
      var Super = _getPrototypeOf(Derived),
        result;
      if (hasNativeReflectConstruct) {
        var NewTarget = _getPrototypeOf(this).constructor;
        result = Reflect.construct(Super, arguments, NewTarget);
      } else {
        result = Super.apply(this, arguments);
      }
      return _possibleConstructorReturn(this, result);
    };
  }
  function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
  }
  function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
  }
  function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
  }
  function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
  }
  function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];
    return arr2;
  }
  function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
  }
  function _toPrimitive(input, hint) {
    if (typeof input !== "object" || input === null) return input;
    var prim = input[Symbol.toPrimitive];
    if (prim !== undefined) {
      var res = prim.call(input, hint || "default");
      if (typeof res !== "object") return res;
      throw new TypeError("@@toPrimitive must return a primitive value.");
    }
    return (hint === "string" ? String : Number)(input);
  }
  function _toPropertyKey(arg) {
    var key = _toPrimitive(arg, "string");
    return typeof key === "symbol" ? key : String(key);
  }

  /** @type {Toast} */
  var toast = document.querySelector('toast-message');
  window.toast = toast;

  function getCookie(name) {
    var value = "; ".concat(document.cookie);
    var parts = value.split("; ".concat(name, "="));
    if (parts.length === 2) return parts.pop().split(';').shift();
  }
  function getJwtToken() {
    return localStorage.getItem('jwt') || getCookie('user');
  }

  /**
   * Extended options for the Fetch request.
   * 
   * @typedef {Object} ResponseAddition
   * @property {Object} data - The JSON response data.
   * 
   * @typedef {Response & ResponseAddition} ExtendedResponse
   */

  /**
   * Extended options for the Fetch request.
   * 
   * @typedef {Object} FetchOptions
   * @property {Record<string, string>} [params] - Query parameter key-value pairs to be appended to the URL.
   * @property {'default' | 'no-store' | 'reload' | 'no-cache' | 'force-cache' | 'only-if-cached'} [cache] - Controls how the request can be cached.
   * @property {'high' | 'low' | 'auto'} [priority] - Indicates the importance of the request.
   * @property {'follow' | 'error' | 'manual'} [redirect] - Controls the behavior of following HTTP redirects.
   * @property {boolean|function(Response)} errorHandler=true - Whether to show a toast message on error.
   */

  /**
   * Defines the API's structure for making HTTP requests.
   *
   * @typedef {Object} Api
   * @property {function(string|URL, Record<string, string>, RequestInit & FetchOptions): Promise<ExtendedResponse>} get - Makes a GET request using the Fetch API.
   * @property {function(string|URL, Record<string, any>|FormData|URLSearchParams, RequestInit & FetchOptions): Promise<ExtendedResponse>} post - Makes a POST request.
   * @property {function(string|URL, Record<string, any>|FormData|URLSearchParams, RequestInit & FetchOptions): Promise<ExtendedResponse>} patch - Makes a PATCH request.
   * @property {function(string|URL, Record<string, any>|FormData|URLSearchParams, RequestInit & FetchOptions): Promise<ExtendedResponse>} put - Makes a PUT request.
   * @property {function(string|URL, RequestInit & FetchOptions): Promise<ExtendedResponse>} delete - Makes a DELETE request.
   */

  var ApiError = /*#__PURE__*/function (_Error) {
    _inherits(ApiError, _Error);
    var _super = _createSuper(ApiError);
    /**
     * @param {Response} response
     * @param {string} message 
     */
    function ApiError(response, message) {
      var _this;
      _classCallCheck(this, ApiError);
      _this = _super.call(this, message);
      _this.response = response;
      return _this;
    }
    return _createClass(ApiError);
  }( /*#__PURE__*/_wrapNativeSuper(Error));
  var Api = /*#__PURE__*/function () {
    function Api() {
      _classCallCheck(this, Api);
      _defineProperty(this, "base", null);
    }
    _createClass(Api, [{
      key: "getDefaultHeaders",
      value: function getDefaultHeaders() {
        return {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        };
      }

      /**
       * Makes an HTTP request using the Fetch API.
       *
       * @param {string} [method='GET'] - The HTTP method.
       * @param {string|URL} url - The URL to send the request to.
       * @param {RequestInit & FetchOptions} [options={}] - Additional options for the request.
       * @returns {Promise<ExtendedResponse>} A Promise that resolves to the Response object representing the response to the request.
       */
    }, {
      key: "request",
      value: function () {
        var _request = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
          var method,
            url,
            options,
            opts,
            token,
            _args2 = arguments;
          return _regeneratorRuntime().wrap(function _callee2$(_context2) {
            while (1) switch (_context2.prev = _context2.next) {
              case 0:
                method = _args2.length > 0 && _args2[0] !== undefined ? _args2[0] : 'GET';
                url = _args2.length > 1 ? _args2[1] : undefined;
                options = _args2.length > 2 && _args2[2] !== undefined ? _args2[2] : {};
                opts = {
                  method: method,
                  headers: this.getDefaultHeaders() // Use method to avoid reference issues
                };
                token = getJwtToken();
                if (token) {
                  opts.headers['Authorization'] = "Bearer ".concat(token);
                }
                if (module_default$2.store('workspace')) {
                  opts.headers['X-Workspace-Id'] = module_default$2.store('workspace').id;
                }
                url = url instanceof URL ? url : new URL(((this.base || '') + "/" + url).replace(/([^:]\/)\/+/g, "$1"), window.location.origin);
                if (options.params) {
                  Object.keys(options.params).forEach(function (key) {
                    return url.searchParams.append(key, options.params[key]);
                  });
                  delete options.params;
                }
                options = _objectSpread2(_objectSpread2({}, opts), options);
                if (options.body) {
                  if (options.body instanceof FormData) {
                    // FormData already sets the correct Content-Type with the boundary
                    delete options.headers['Content-Type'];
                  } else if (options.body instanceof URLSearchParams) {
                    options.headers['Content-Type'] = 'application/x-www-form-urlencoded';
                  } else if (options.headers['Content-Type'] === 'application/json' && typeof options.body !== 'string') {
                    options.body = JSON.stringify(options.body);
                  }
                }
                return _context2.abrupt("return", fetch(url, _objectSpread2(_objectSpread2({}, opts), options)).then( /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(response) {
                    var clone, message;
                    return _regeneratorRuntime().wrap(function _callee$(_context) {
                      while (1) switch (_context.prev = _context.next) {
                        case 0:
                          clone = response.clone();
                          response.data = {};
                          if (!(response.headers.get('Content-Type') && response.headers.get('Content-Type').toLocaleLowerCase().includes('application/json'))) {
                            _context.next = 11;
                            break;
                          }
                          _context.prev = 3;
                          _context.next = 6;
                          return clone.json();
                        case 6:
                          response.data = _context.sent;
                          _context.next = 11;
                          break;
                        case 9:
                          _context.prev = 9;
                          _context.t0 = _context["catch"](3);
                        case 11:
                          if (!response.ok) {
                            _context.next = 13;
                            break;
                          }
                          return _context.abrupt("return", response);
                        case 13:
                          message = response.data.message || null;
                          if (message) {
                            toast.error(message);
                            window.modal.close();
                          }
                          throw new ApiError(response, message || response.statusText);
                        case 16:
                        case "end":
                          return _context.stop();
                      }
                    }, _callee, null, [[3, 9]]);
                  }));
                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }()));
              case 12:
              case "end":
                return _context2.stop();
            }
          }, _callee2, this);
        }));
        function request() {
          return _request.apply(this, arguments);
        }
        return request;
      }()
      /**
       * Makes a GET request using the Fetch API.
       *
       * @param {string|URL} url - The URL to send the request to.
       * @param {Record<string, string>} [params={}] - Query parameter key-value pairs to be appended to the URL.
       * @param {RequestInit & FetchOptions} [options={}] - Additional options for the request.
       * @returns {Promise<ExtendedResponse>} A Promise that resolves to the Response object representing the response to the request.
       */
    }, {
      key: "get",
      value: function get(url) {
        var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
        return this.request('GET', url, _objectSpread2(_objectSpread2({}, options), {}, {
          params: params
        }));
      }

      /**
       * Makes a POST request using the Fetch API.
       *
       * @param {string|URL} url - The URL to send the request to.
       * @param {Record<string, any>|FormData|URLSearchParams} [body={}] - The body of the request.
       * @param {RequestInit & FetchOptions} [options={}] - Additional options for the request.
       * @returns {Promise<ExtendedResponse>} A Promise that resolves to the Response object representing the response to the request.
       */
    }, {
      key: "post",
      value: function post(url) {
        var body = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
        return this.request('POST', url, _objectSpread2(_objectSpread2({}, options), {}, {
          body: body
        }));
      }

      /**
       * Makes a PATCH request using the Fetch API.
       *
       * @param {string|URL} url - The URL to send the request to.
       * @param {Record<string, any>|FormData|URLSearchParams} [body={}] - The body of the request.
       * @param {RequestInit & FetchOptions} [options={}] - Additional options for the request.
       * @returns {Promise<ExtendedResponse>} A Promise that resolves to the Response object representing the response to the request.
       */
    }, {
      key: "patch",
      value: function patch(url) {
        var body = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
        return this.request('PATCH', url, _objectSpread2(_objectSpread2({}, options), {}, {
          body: body
        }));
      }

      /**
       * Makes a PUT request using the Fetch API.
       *
       * @param {string|URL} url - The URL to send the request to.
       * @param {Record<string, any>|FormData|URLSearchParams} [body={}] - The body of the request.
       * @param {RequestInit & FetchOptions} [options={}] - Additional options for the request.
       * @returns {Promise<ExtendedResponse>} A Promise that resolves to the Response object representing the response to the request.
       */
    }, {
      key: "put",
      value: function put(url) {
        var body = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
        return this.request('PUT', url, _objectSpread2(_objectSpread2({}, options), {}, {
          body: body
        }));
      }

      /**
       * Makes a DELETE request using the Fetch API.
       *
       * @param {string|URL} url - The URL to send the request to.
       * @param {RequestInit & FetchOptions} [options={}] - Additional options for the request.
       * @returns {Promise<ExtendedResponse>} A Promise that resolves to the Response object representing the response to the request.
       */
    }, {
      key: "remove",
      value: function remove(url, options) {
        return this.request('DELETE', url, options);
      }

      /**
      * Makes a DELETE request using the Fetch API.
      *
      * @param {string|URL} url - The URL to send the request to.
      * @param {RequestInit & FetchOptions} [options={}] - Additional options for the request.
      * @returns {Promise<ExtendedResponse>} A Promise that resolves to the Response object representing the response to the request.
      */
    }, {
      key: "delete",
      value: function _delete(url, options) {
        return this.remove(url, options);
      }
    }]);
    return Api;
  }();

  var api = new Api();
  api.base = '/admin/api';

  function getCategoryList() {
    var categories = [];
    var fetchedAll = false;
    function getList() {
      return _getList.apply(this, arguments);
    }
    function _getList() {
      _getList = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var cursor,
          params,
          response,
          _args = arguments;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              cursor = _args.length > 0 && _args[0] !== undefined ? _args[0] : null;
              params = {};
              if (cursor) {
                params.starting_after = cursor;
              }
              _context.next = 5;
              return api.get('categories', params);
            case 5:
              response = _context.sent;
              if (!(response.data.data.length == 0)) {
                _context.next = 9;
                break;
              }
              fetchedAll = true;
              return _context.abrupt("return");
            case 9:
              categories.push.apply(categories, _toConsumableArray(response.data.data));
              if (!fetchedAll) {
                getList(categories[categories.length - 1].id);
              }
              return _context.abrupt("return", categories);
            case 12:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }));
      return _getList.apply(this, arguments);
    }
    return getList();
  }
  function getPlanList() {
    var plans = [];
    var fetchedAll = false;
    function getList() {
      return _getList2.apply(this, arguments);
    }
    function _getList2() {
      _getList2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var cursor,
          params,
          response,
          _args2 = arguments;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              cursor = _args2.length > 0 && _args2[0] !== undefined ? _args2[0] : null;
              params = {};
              if (cursor) {
                params.starting_after = cursor;
              }
              _context2.next = 5;
              return api.get('plans', params);
            case 5:
              response = _context2.sent;
              if (!(response.data.data.length == 0)) {
                _context2.next = 9;
                break;
              }
              fetchedAll = true;
              return _context2.abrupt("return");
            case 9:
              plans.push.apply(plans, _toConsumableArray(response.data.data));
              if (!fetchedAll) {
                getList(plans[plans.length - 1].id);
              }
              return _context2.abrupt("return", plans);
            case 12:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }));
      return _getList2.apply(this, arguments);
    }
    return getList();
  }

  function listView() {
    module_default$2.data('lc', function () {
      var filters = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
      var sort = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
      return {
        filters: filters,
        sort: sort,
        orderby: null,
        dir: null,
        params: {
          query: null,
          sort: null
        },
        // total: null,
        init: function init() {
          var _this = this;
          this.filters.forEach(function (filter) {
            return _this.params[filter.model] = null;
          });
          this.getCategories();
          this.getPlans();
          var sortparams = ['orderby', 'dir'];
          sortparams.forEach(function (param) {
            _this.$watch(param, function () {
              _this.params.sort = null;
              if (_this.orderby) {
                _this.params.sort = _this.orderby;
                if (_this.dir) {
                  _this.params.sort += ":".concat(_this.dir);
                }
              }
            });
          });
          this.$watch('params', function (params) {
            _this.$dispatch('lc.filtered', params);
            _this.updateUrl();
          });
          this.parseUrl();
          window.addEventListener('lc.reset', function () {
            return _this.resetFilters();
          });
        },
        resetFilters: function resetFilters() {
          for (var key in this.params) {
            if (key != 'sort') {
              this.params[key] = null;
            }
          }
        },
        getCategories: function getCategories() {
          var _this2 = this;
          var filter = this.filters.find(function (filter) {
            return filter.model == 'category';
          });
          if (!filter) {
            return;
          }
          getCategoryList().then(function (categories) {
            categories.forEach(function (category) {
              filter.options.push({
                value: category.id,
                label: category.title
              });
            });
            _this2.parseUrl();
          });
        },
        getPlans: function getPlans() {
          var _this3 = this;
          var filter = this.filters.find(function (filter) {
            return filter.model == 'plan';
          });
          if (!filter) {
            return;
          }
          var cycles = filter.billing_cycle || [];
          getPlanList().then(function (plans) {
            plans.forEach(function (plan) {
              if (cycles.length == 0 || cycles.includes(plan.billing_cycle)) {
                filter.options.push({
                  value: plan.id,
                  label: plan.title + ' / ' + plan.billing_cycle
                });
              }
            });
            _this3.parseUrl();
          });
        },
        parseUrl: function parseUrl() {
          var _this4 = this;
          var url = new URL(window.location.href);
          var params = new URLSearchParams(url.search.slice(1));
          var _loop = function _loop(key) {
            var _filter$options;
            if (!params.has(key)) {
              return "continue";
            }
            var filter = _this4.filters.find(function (f) {
              return f.model == key;
            });
            if (!filter) {
              return "continue";
            }
            var option = (_filter$options = filter.options) === null || _filter$options === void 0 ? void 0 : _filter$options.find(function (o) {
              return o.value == params.get(key);
            });
            if (!option && !filter.hidden) {
              return "continue";
            }
            _this4.params[key] = params.get(key);
          };
          for (var key in this.params) {
            var _ret = _loop(key);
            if (_ret === "continue") continue;
          }
          if (this.params.sort) {
            var _sort = this.params.sort.split(':');
            this.orderby = _sort[0];
            this.dir = _sort[1] || 'asc';
          }
        },
        updateUrl: function updateUrl() {
          var url = new URL(window.location.href);
          var params = new URLSearchParams(url.search.slice(1));
          for (var key in this.params) {
            if (this.params[key]) {
              params.set(key, this.params[key]);
            } else {
              params["delete"](key);
            }
          }
          window.history.pushState({}, '', "".concat(url.origin).concat(url.pathname, "?").concat(params));
        }
      };
    });
    module_default$2.data('list', function (basePath) {
      var strings = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
      return {
        state: 'initial',
        params: {},
        total: null,
        cursor: null,
        resources: [],
        isLoading: false,
        hasMore: true,
        isFiltered: false,
        currentResource: null,
        isDeleting: false,
        isExporting: false,
        init: function init() {
          var _this5 = this;
          this.loadMore();
          this.getTotalCount();
          var timer = null;
          timer = setTimeout(function () {
            return _this5.retrieveResources();
          }, 200);
          window.addEventListener('lc.filtered', function (e) {
            clearTimeout(timer);
            timer = setTimeout(function () {
              _this5.params = e.detail;
              _this5.retrieveResources(true);
            }, 200);
          });
        },
        getTotalCount: function getTotalCount() {
          var _this6 = this;
          api.get("".concat(basePath, "/count")).then(function (response) {
            _this6.total = response.data.count;
          });
        },
        exportData: function exportData() {
          var _this7 = this;
          this.isExporting = true;
          api.post("".concat(basePath, "/export")).then(function (response) {
            toast.success('Export sent to your email!');
            _this7.isExporting = false;
          })["catch"](function (error) {
            return _this7.isExporting = false;
          });
        },
        retrieveResources: function retrieveResources() {
          var _this8 = this;
          var reset = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
          this.isLoading = true;
          var params = {};
          var isFiltered = false;
          for (var key in this.params) {
            if (this.params[key]) {
              if (key != 'sort') {
                isFiltered = true;
              }
              params[key] = this.params[key];
            }
          }
          this.isFiltered = isFiltered;
          if (!reset && this.cursor) {
            params.starting_after = this.cursor;
          }
          api.get(basePath, params).then(function (response) {
            _this8.state = 'loaded';
            _this8.resources = reset ? response.data.data : _this8.resources.concat(response.data.data);
            if (_this8.resources.length > 0) {
              _this8.cursor = _this8.resources[_this8.resources.length - 1].id;
            } else {
              _this8.state = 'empty';
            }
            _this8.isLoading = false;
            _this8.hasMore = response.data.data.length >= 25;
          });
        },
        loadMore: function loadMore() {
          var _this9 = this;
          window.addEventListener('scroll', function () {
            if (_this9.hasMore && !_this9.isLoading && window.innerHeight + window.scrollY + 500 >= document.documentElement.scrollHeight) {
              _this9.retrieveResources();
            }
          });
        },
        toggleStatus: function toggleStatus(resource) {
          resource.status = resource.status == 1 ? 0 : 1;
          api.patch("".concat(basePath, "/").concat(resource.id), {
            status: resource.status
          });
        },
        deleteResource: function deleteResource(resource) {
          var _this10 = this;
          this.isDeleting = true;
          api["delete"]("".concat(basePath, "/").concat(resource.id)).then(function () {
            _this10.resources.splice(_this10.resources.indexOf(resource), 1);
            window.modal.close();
            _this10.currentResource = null;
            toast.show(strings.delete_success, 'ti ti-trash');
            _this10.isDeleting = false;
          })["catch"](function (error) {
            return _this10.isDeleting = false;
          });
        }
      };
    });
  }

  function presetView() {
    module_default$2.data('preset', function (preset) {
      return {
        preset: {},
        model: {},
        isProcessing: false,
        categories: [],
        categoriesFethed: false,
        init: function init() {
          var _this = this;
          this.setPreset(preset);
          getCategoryList().then(function (categories) {
            _this.categories = categories;
            _this.categoriesFethed = true;
          });
        },
        setPreset: function setPreset(preset) {
          var _preset$category;
          this.preset = preset;
          this.model = _objectSpread2({}, this.preset);
          this.model.category_id = (_preset$category = preset.category) === null || _preset$category === void 0 ? void 0 : _preset$category.id;
        },
        submit: function submit() {
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          var data = this.model;
          data.status = data.status ? 1 : 0;
          data.category = this.model.category_id;
          this.preset.id ? this.update(data) : this.create(data);
        },
        update: function update(data) {
          var _this2 = this;
          api.patch("/presets/".concat(this.preset.id), data).then(function (response) {
            _this2.setPreset(response.data);
            _this2.isProcessing = false;
            toast.success('Template has been updated successfully!');
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        },
        create: function create(data) {
          var _this3 = this;
          api.post('/presets', data).then(function (response) {
            toast.defer('Template has been created successfully!');
            window.location = '/admin/templates/';
          })["catch"](function (error) {
            return _this3.isProcessing = false;
          });
        },
        sanitizeColor: function sanitizeColor(input, el) {
          var sanitizedInput = input.replace(/[^0-9A-Fa-f]/g, '').toUpperCase();
          if (/^([0-9A-Fa-f]{3}){1,2}$/.test(sanitizedInput)) {
            this.model.color = "#".concat(sanitizedInput.padEnd(6, '0').slice(0, 6));
          } else {
            this.model.color = "#000000";
          }
        }
      };
    });
  }

  function userView() {
    module_default$2.data('user', function (user) {
      return {
        user: {},
        model: {
          role: 0
        },
        isProcessing: false,
        init: function init() {
          this.user = user;
          this.model = _objectSpread2(_objectSpread2({}, this.model), this.user);
        },
        submit: function submit() {
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          var data = this.model;
          data.status = data.status ? 1 : 0;
          this.user.id ? this.update(data) : this.create(data);
        },
        update: function update(data) {
          var _this = this;
          api.patch("/users/".concat(this.user.id), data).then(function (response) {
            _this.user = response.data;
            _this.model = _objectSpread2({}, _this.user);
            _this.isProcessing = false;
            toast.success('User has been updated successfully!');
          })["catch"](function (error) {
            return _this.isProcessing = false;
          });
        },
        create: function create(data) {
          var _this2 = this;
          api.post('/users', data).then(function (response) {
            toast.defer('User has been created successfully!');
            window.location = "/admin/users/";
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        }
      };
    });
  }

  function categoryView() {
    module_default$2.data('category', function (category) {
      return {
        category: {},
        model: {},
        isProcessing: false,
        init: function init() {
          this.category = category;
          this.model = _objectSpread2({}, this.category);
        },
        submit: function submit() {
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          this.category.id ? this.update() : this.create();
        },
        update: function update() {
          var _this = this;
          api.patch("/categories/".concat(this.category.id), this.model).then(function (response) {
            _this.category = response.data;
            _this.model = _objectSpread2({}, _this.category);
            _this.isProcessing = false;
            toast.success('Category has been updated successfully!');
          })["catch"](function (error) {
            return _this.isProcessing = false;
          });
        },
        create: function create() {
          var _this2 = this;
          api.post('/categories', this.model).then(function (response) {
            toast.defer('Category has been created successfully!');
            window.location = '/admin/categories';
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        }
      };
    });
  }

  function planView() {
    module_default$2.data('plan', function (currency) {
      var plan = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      return {
        plan: plan || {},
        currency: currency,
        model: {
          billing_cycle: 'monthly',
          config: {
            writer: {},
            coder: {},
            imagine: {},
            transcriber: {},
            voiceover: {},
            titler: {},
            models: {}
          },
          update_snapshots: false
        },
        isProcessing: false,
        init: function init() {
          this.setModel(_objectSpread2({}, this.plan));
          this.watch();
        },
        setModel: function setModel(model) {
          this.model = _objectSpread2(_objectSpread2({}, this.model), model);
          this.model.price = (model.price / Math.pow(10, currency.fraction_digits)).toFixed(currency.fraction_digits);
          this.model.status = model.status == 1;
          this.model.is_featured = model.is_featured == 1;
          var event = new Event("input", {
            bubbles: true
          });
          this.$refs.price.dispatchEvent(event);
        },
        watch: function watch() {
          var _this = this;
          this.$watch("model.credit_count", function (value) {
            _this.model.credit_count = value < 0 || value.toString().trim() === "" ? null : value;
          });
        },
        submit: function submit() {
          if (this.isProcessing) {
            return;
          }
          var data = _objectSpread2({}, this.model);
          data.status = data.status ? 1 : 0;
          data.is_featured = data.is_featured ? 1 : 0;
          data.price = (data.price.replaceAll(' ', '') * Math.pow(10, currency.fraction_digits)).toFixed(0);
          this.isProcessing = true;
          this.plan.id ? this.update(data) : this.create(data);
        },
        update: function update(data) {
          var _this2 = this;
          api.patch("/plans/".concat(this.plan.id), data).then(function (response) {
            _this2.plan = response.data;
            _this2.setModel(_objectSpread2({}, _this2.plan));
            _this2.isProcessing = false;
            toast.success('Plan has been updated successfully!');
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        },
        create: function create(data) {
          var _this3 = this;
          api.post('/plans', data).then(function (response) {
            toast.defer('Plan has been created successfully!');
            window.location = "/admin/plans/";
          })["catch"](function (error) {
            return _this3.isProcessing = false;
          });
        }
      };
    });
  }

  var CustomFormData = /*#__PURE__*/function (_FormData) {
    _inherits(CustomFormData, _FormData);
    var _super = _createSuper(CustomFormData);
    /**
     * @param {HTMLFormElement|Object||null} form 
     */
    function CustomFormData() {
      var _this;
      var form = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      _classCallCheck(this, CustomFormData);
      if (form instanceof HTMLFormElement) {
        _this = _super.call(this, form);
      } else {
        _this = _super.call(this);
      }
      if (form instanceof HTMLFormElement) {
        form.querySelectorAll('input[type="checkbox"]').forEach(function (element) {
          if (element.name) {
            if (element.checked === false) {
              if (element.value === '1') {
                _this.append(element.name, '0');
              } else if (element.value === '0') {
                _this.append(element.name, '1');
              } else if (element.value === 'true') {
                _this.append(element.name, 'false');
              } else if (element.value === 'false') {
                _this.append(element.name, 'true');
              } else if (!element.hasAttribute('value')) {
                _this.append(element.name, '0');
              }
            } else {
              _this.append(element.name, element.hasAttribute('value') ? element.value : '1');
            }
          }
        });
      } else if (!(form instanceof HTMLFormElement)) {
        for (var key in form) {
          if (form.hasOwnProperty(key)) {
            var value = form[key];
            _this.append(key, value);
          }
        }
      }
      return _possibleConstructorReturn(_this);
    }
    _createClass(CustomFormData, [{
      key: "toJson",
      value: function () {
        var _toJson = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
          var _this2 = this;
          var jsonObject, filePromises;
          return _regeneratorRuntime().wrap(function _callee$(_context) {
            while (1) switch (_context.prev = _context.next) {
              case 0:
                jsonObject = {};
                filePromises = [];
                this.forEach(function (value, key) {
                  // Split the key into parts based on [] or [key]
                  var keys = key.split(/\[(.*?)\]/).filter(Boolean);

                  // Initialize a reference to traverse jsonObject
                  var current = jsonObject;

                  // Traverse through each key part
                  var _loop = function _loop() {
                    var k = keys[i];

                    // If it's the last key part, assign the value
                    if (i === keys.length - 1) {
                      // Check if the key already exists in jsonObject
                      if (Object.prototype.hasOwnProperty.call(current, k)) {
                        // If it's an array, push the value
                        if (!Array.isArray(current[k])) {
                          current[k] = [current[k]];
                        }
                        current[k].push(value);
                      } else {
                        // If it's a file input, append File object directly
                        if (value instanceof File) {
                          current[k] = value;
                          var filePromise = _this2.readFileAsBase64(value).then(function (base64String) {
                            current[k] = base64String;
                          });
                          filePromises.push(filePromise);
                        } else {
                          // Otherwise, set the value
                          current[k] = value;
                        }
                      }
                    } else {
                      // If the key doesn't exist or isn't an object, create an empty object
                      if (!current[k] || _typeof(current[k]) !== 'object') {
                        current[k] = {};
                      }

                      // Move to the next level in jsonObject
                      current = current[k];
                    }
                  };
                  for (var i = 0; i < keys.length; i++) {
                    _loop();
                  }
                });

                // Wait for all file read operations to complete
                _context.next = 5;
                return Promise.all(filePromises);
              case 5:
                return _context.abrupt("return", jsonObject);
              case 6:
              case "end":
                return _context.stop();
            }
          }, _callee, this);
        }));
        function toJson() {
          return _toJson.apply(this, arguments);
        }
        return toJson;
      }()
    }, {
      key: "readFileAsBase64",
      value: function readFileAsBase64(file) {
        return new Promise(function (resolve, reject) {
          var reader = new FileReader();
          reader.onload = function (e) {
            var base64String = e.target.result.replace("data:", "").replace(/^.+,/, "");
            resolve(base64String);
          };
          reader.onerror = function (error) {
            reject(error);
          };
          reader.readAsDataURL(file);
        });
      }
    }]);
    return CustomFormData;
  }( /*#__PURE__*/_wrapNativeSuper(FormData));

  function settingsView() {
    module_default$2.data('settings', function (path) {
      return {
        required: [],
        isProcessing: false,
        plans: [],
        plansFetched: false,
        init: function init() {
          var _this = this;
          getPlanList().then(function (plans) {
            _this.plans = plans;
            _this.plansFetched = true;
          });
        },
        submit: function submit() {
          var _this2 = this;
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          var data = new CustomFormData(this.$refs.form);
          api.post("/options".concat(this.$refs.form.dataset.path || ''), data).then(function (response) {
            _this2.isProcessing = false;
            toast.show('Changes saved successfully!', 'ti ti-square-rounded-check-filled');
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        },
        clearCache: function clearCache() {
          var _this3 = this;
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          api["delete"]("/cache").then(function () {
            _this3.isProcessing = false;
            toast.show('Cache cleared successfully!', 'ti ti-square-rounded-check-filled');
          })["catch"](function (error) {
            return _this3.isProcessing = false;
          });
        }
      };
    });
    module_default$2.data('colorSchemes', function (light, dark, def) {
      return {
        light: light,
        dark: dark,
        def: def,
        init: function init() {
          var _this4 = this;
          ['light', 'dark'].forEach(function (scheme) {
            _this4.$watch(scheme, function (val) {
              if (!val) {
                scheme == 'light' ? _this4.dark = true : _this4.light = true;
                if (_this4.def == scheme) {
                  _this4.def = 'system';
                }
              }
            });
          });
        }
      };
    });
  }

  function pluginsView() {
    module_default$2.data('plugins', function () {
      var strings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
      var activeTheme = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      return {
        state: 'initial',
        activeTheme: activeTheme,
        type: 'plugin',
        params: {},
        total: null,
        cursor: null,
        resources: [],
        isLoading: false,
        currentResource: null,
        isFiltered: false,
        isDeleting: false,
        isPublishing: false,
        init: function init() {
          var _this = this;
          if (this.activeTheme) {
            this.type = 'theme';
          }
          this.getTotalCount();
          this.retrieveResources();
          var timer = null;
          window.addEventListener('lc.filtered', function (e) {
            clearTimeout(timer);
            timer = setTimeout(function () {
              _this.params = e.detail;
              _this.retrieveResources(true);
            }, 200);
          });
        },
        getTotalCount: function getTotalCount() {
          var _this2 = this;
          api.get("plugins/count", {
            type: this.type
          }).then(function (response) {
            _this2.total = response.data.count;
          });
        },
        retrieveResources: function retrieveResources() {
          var _this3 = this;
          var reset = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
          this.isLoading = true;
          var params = {
            type: this.type
          };
          var isFiltered = false;
          for (var key in this.params) {
            if (this.params[key]) {
              isFiltered = true;
              params[key] = this.params[key];
            }
          }
          this.isFiltered = isFiltered;
          if (!reset && this.cursor) {
            params.starting_after = this.cursor;
          }
          api.get("plugins", params).then(function (response) {
            _this3.state = 'loaded';
            _this3.resources = reset ? response.data.data : _this3.resources.concat(response.data.data);
            if (_this3.resources.length > 0) {
              _this3.cursor = _this3.resources[_this3.resources.length - 1].id;
            } else {
              _this3.state = 'empty';
            }
            _this3.isLoading = false;
          });
        },
        toggleStatus: function toggleStatus(resource) {
          resource.status = resource.status == 'active' ? 'inactive' : 'active';
          api.post("plugins/".concat(resource.name), {
            status: resource.status
          });
        },
        publish: function publish(theme) {
          var _this4 = this;
          if (this.isPublishing) {
            return;
          }
          this.isPublishing = theme.name;
          api.post("options/", {
            theme: theme.name
          }).then(function () {
            _this4.activeTheme = theme.name;
            _this4.isPublishing = false;
          })["catch"](function (error) {
            _this4.isPublishing = false;
          });
        },
        deleteResource: function deleteResource(resource) {
          var _this5 = this;
          this.isDeleting = true;
          api["delete"]("plugins/".concat(resource.name)).then(function () {
            _this5.resources.splice(_this5.resources.indexOf(resource), 1);
            window.modal.close();
            _this5.currentResource = null;
            toast.show(strings.delete_success, 'ti ti-trash');
            _this5.isDeleting = false;
          })["catch"](function (error) {
            _this5.isDeleting = false;
          });
        }
      };
    });
  }

  /**
   * filesize
   *
   * @copyright 2023 Jason Mulligan <jason.mulligan@avoidwork.com>
   * @license BSD-3-Clause
   * @version 10.1.0
   */
  const ARRAY = "array";
  const BIT = "bit";
  const BITS = "bits";
  const BYTE = "byte";
  const BYTES = "bytes";
  const EMPTY = "";
  const EXPONENT = "exponent";
  const FUNCTION = "function";
  const IEC = "iec";
  const INVALID_NUMBER = "Invalid number";
  const INVALID_ROUND = "Invalid rounding method";
  const JEDEC = "jedec";
  const OBJECT = "object";
  const PERIOD = ".";
  const ROUND = "round";
  const S = "s";
  const SI = "si";
  const SI_KBIT = "kbit";
  const SI_KBYTE = "kB";
  const SPACE = " ";
  const STRING = "string";
  const ZERO = "0";
  const STRINGS = {
    symbol: {
      iec: {
        bits: ["bit", "Kibit", "Mibit", "Gibit", "Tibit", "Pibit", "Eibit", "Zibit", "Yibit"],
        bytes: ["B", "KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"]
      },
      jedec: {
        bits: ["bit", "Kbit", "Mbit", "Gbit", "Tbit", "Pbit", "Ebit", "Zbit", "Ybit"],
        bytes: ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"]
      }
    },
    fullform: {
      iec: ["", "kibi", "mebi", "gibi", "tebi", "pebi", "exbi", "zebi", "yobi"],
      jedec: ["", "kilo", "mega", "giga", "tera", "peta", "exa", "zetta", "yotta"]
    }
  };
  function filesize(arg, {
    bits = false,
    pad = false,
    base = -1,
    round = 2,
    locale = EMPTY,
    localeOptions = {},
    separator = EMPTY,
    spacer = SPACE,
    symbols = {},
    standard = EMPTY,
    output = STRING,
    fullform = false,
    fullforms = [],
    exponent = -1,
    roundingMethod = ROUND,
    precision = 0
  } = {}) {
    let e = exponent,
      num = Number(arg),
      result = [],
      val = 0,
      u = EMPTY;

    // Sync base & standard
    if (standard === SI) {
      base = 10;
      standard = JEDEC;
    } else if (standard === IEC || standard === JEDEC) {
      base = 2;
    } else if (base === 2) {
      standard = IEC;
    } else {
      base = 10;
      standard = JEDEC;
    }
    const ceil = base === 10 ? 1000 : 1024,
      full = fullform === true,
      neg = num < 0,
      roundingFunc = Math[roundingMethod];
    if (typeof arg !== "bigint" && isNaN(arg)) {
      throw new TypeError(INVALID_NUMBER);
    }
    if (typeof roundingFunc !== FUNCTION) {
      throw new TypeError(INVALID_ROUND);
    }

    // Flipping a negative number to determine the size
    if (neg) {
      num = -num;
    }

    // Determining the exponent
    if (e === -1 || isNaN(e)) {
      e = Math.floor(Math.log(num) / Math.log(ceil));
      if (e < 0) {
        e = 0;
      }
    }

    // Exceeding supported length, time to reduce & multiply
    if (e > 8) {
      if (precision > 0) {
        precision += 8 - e;
      }
      e = 8;
    }
    if (output === EXPONENT) {
      return e;
    }

    // Zero is now a special case because bytes divide by 1
    if (num === 0) {
      result[0] = 0;
      u = result[1] = STRINGS.symbol[standard][bits ? BITS : BYTES][e];
    } else {
      val = num / (base === 2 ? Math.pow(2, e * 10) : Math.pow(1000, e));
      if (bits) {
        val = val * 8;
        if (val >= ceil && e < 8) {
          val = val / ceil;
          e++;
        }
      }
      const p = Math.pow(10, e > 0 ? round : 0);
      result[0] = roundingFunc(val * p) / p;
      if (result[0] === ceil && e < 8 && exponent === -1) {
        result[0] = 1;
        e++;
      }
      u = result[1] = base === 10 && e === 1 ? bits ? SI_KBIT : SI_KBYTE : STRINGS.symbol[standard][bits ? BITS : BYTES][e];
    }

    // Decorating a 'diff'
    if (neg) {
      result[0] = -result[0];
    }

    // Setting optional precision
    if (precision > 0) {
      result[0] = result[0].toPrecision(precision);
    }

    // Applying custom symbol
    result[1] = symbols[result[1]] || result[1];
    if (locale === true) {
      result[0] = result[0].toLocaleString();
    } else if (locale.length > 0) {
      result[0] = result[0].toLocaleString(locale, localeOptions);
    } else if (separator.length > 0) {
      result[0] = result[0].toString().replace(PERIOD, separator);
    }
    if (pad && Number.isInteger(result[0]) === false && round > 0) {
      const x = separator || PERIOD,
        tmp = result[0].toString().split(x),
        s = tmp[1] || EMPTY,
        l = s.length,
        n = round - l;
      result[0] = `${tmp[0]}${x}${s.padEnd(l + n, ZERO)}`;
    }
    if (full) {
      result[1] = fullforms[e] ? fullforms[e] : STRINGS.fullform[standard][e] + (bits ? BIT : BYTE) + (result[0] === 1 ? EMPTY : S);
    }

    // Returning Array, Object, or String (default)
    return output === ARRAY ? result : output === OBJECT ? {
      value: result[0],
      symbol: result[1],
      exponent: e,
      unit: u
    } : result.join(spacer);
  }

  function pluginView() {
    module_default$2.data('plugin', function () {
      return {
        file: null,
        isProcessing: false,
        error: null,
        init: function init() {},
        filesize: function filesize$1() {
          return filesize(this.file.size);
        },
        submit: function submit() {
          var _this = this;
          return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
            var data, resp, msg;
            return _regeneratorRuntime().wrap(function _callee$(_context) {
              while (1) switch (_context.prev = _context.next) {
                case 0:
                  if (!(!_this.file || _this.isProcessing)) {
                    _context.next = 2;
                    break;
                  }
                  return _context.abrupt("return");
                case 2:
                  _this.isProcessing = true;
                  data = new FormData();
                  data.append('file', _this.file);
                  _context.prev = 5;
                  _context.next = 8;
                  return api.post("/plugins", data);
                case 8:
                  resp = _context.sent;
                  _context.next = 18;
                  break;
                case 11:
                  _context.prev = 11;
                  _context.t0 = _context["catch"](5);
                  msg = 'An unexpected error occurred! Please try again later!';
                  if (_context.t0.response && _context.t0.response.data.message) {
                    msg = _context.t0.response.data.message;
                  }
                  _this.isProcessing = false;
                  _this.error = msg;
                  return _context.abrupt("return");
                case 18:
                  api.post("/plugins/".concat(resp.data.name, "/initialize")).then(function () {
                    if (resp.data.type === 'theme') {
                      toast.defer('Theme installed successfully!');
                      window.location.href = "admin/themes/";
                      return;
                    }
                    toast.defer('Plugin installed successfully!');
                    window.location.href = "admin/plugins/";
                  })["catch"](function (error) {
                    var msg = 'An unexpected error occurred! Please try again later!';
                    if (error.response && error.response.data.message) {
                      msg = error.response.data.message;
                    }
                    _this.isProcessing = false;
                    _this.error = msg;
                  });
                case 19:
                case "end":
                  return _context.stop();
              }
            }, _callee, null, [[5, 11]]);
          }))();
        }
      };
    });
  }

  function workspaceView() {
    module_default$2.data('workspace', function (workspace) {
      return {
        workspace: workspace,
        isProcessing: false,
        plans: [],
        orders: [],
        init: function init() {
          this.getPlans();
          this.getOrders();
        },
        rename: function rename(name) {
          var _this = this;
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          api.patch("/workspaces/".concat(this.workspace.id), {
            name: name
          }).then(function (response) {
            _this.workspace = response.data;
            _this.isProcessing = false;
            toast.show('Workspace name updated!', 'ti ti-square-rounded-check-filled');
            window.modal.close();
          })["catch"](function (error) {
            return _this.isProcessing = false;
          });
        },
        subscribe: function subscribe(plan_id) {
          var _this2 = this;
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          api.post("/subscriptions/", {
            workspace_id: this.workspace.id,
            plan_id: plan_id
          }).then(function (response) {
            _this2.workspace.subscription = response.data;
            _this2.isProcessing = false;
            toast.show('Subscription created successfully!', 'ti ti-square-rounded-check-filled');
            window.modal.close();
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        },
        getPlans: function getPlans() {
          var _this3 = this;
          var cycles = ['monthly', 'yearly', 'lifetime'];
          getPlanList().then(function (plans) {
            plans.forEach(function (plan) {
              if (cycles.includes(plan.billing_cycle)) {
                _this3.plans.push(plan);
              }
            });
          });
        },
        getOrders: function getOrders() {
          var _this4 = this;
          api.get("/orders?workspace=".concat(this.workspace.id, "&sort=created_at:desc&limit=3")).then(function (response) {
            _this4.orders = response.data.data;
          });
        }
      };
    });
  }

  function subscriptionView() {
    module_default$2.data('subscription', function (subscription) {
      return {
        subscription: subscription,
        isProcessing: false,
        cancelSubscription: function cancelSubscription() {
          var _this = this;
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          api["delete"]("/subscriptions/".concat(subscription.id)).then(function (response) {
            toast.show('Subscription cancelled!', 'ti ti-square-rounded-check-filled');
            window.modal.close();
            _this.subscription = response.data;
            _this.isProcessing = false;
          });
        }
      };
    });
  }

  function planSnapshowView() {
    module_default$2.data('plansnapshot', function (snapshot) {
      return {
        snapshot: snapshot,
        isProcessing: false,
        orders: [],
        init: function init() {
          this.getOrders();
        },
        getOrders: function getOrders() {
          var _this = this;
          api.get("/orders?plan_snapshot=".concat(this.snapshot.id, "&sort=created_at:desc&limit=3")).then(function (response) {
            _this.orders = response.data.data;
          });
        },
        resync: function resync() {
          var _this2 = this;
          if (this.isProcessing) {
            return;
          }
          this.isProcessing = true;
          api.post("/plan-snapshots/".concat(this.snapshot.id, "/resync")).then(function (response) {
            _this2.isProcessing = false;
            _this2.snapshot = response.data;
            window.modal.close();
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        }
      };
    });
  }

  function dashboardView() {
    module_default$2.data('dashboard', function () {
      return {
        isProcessing: false,
        users: [],
        subscriptions: [],
        orders: [],
        stats: null,
        datasets: {},
        init: function init() {
          this.getStats();
          this.getUsageDataset();
          this.getCountryDataset();
          this.getUsers();
          this.getSubscriptions();
          this.getOrders();
        },
        getUsers: function getUsers() {
          var _this = this;
          api.get("/users?sort=created_at:desc&limit=5").then(function (response) {
            _this.users = response.data.data;
          });
        },
        getSubscriptions: function getSubscriptions() {
          var _this2 = this;
          api.get("/subscriptions?sort=created_at:desc&limit=5").then(function (response) {
            _this2.subscriptions = response.data.data;
          });
        },
        getOrders: function getOrders() {
          var _this3 = this;
          api.get("/orders?sort=created_at:desc&limit=5").then(function (response) {
            _this3.orders = response.data.data;
          });
        },
        getStats: function getStats() {
          var _this4 = this;
          api.get("/reports/stats").then(function (response) {
            _this4.stats = response.data;
          });
        },
        getUsageDataset: function getUsageDataset() {
          var _this5 = this;
          api.get("/reports/dataset/usage").then(function (response) {
            _this5.datasets.usage = response.data;
          });
        },
        getCountryDataset: function getCountryDataset() {
          var _this6 = this;
          api.get("/reports/dataset/country").then(function (response) {
            var list = response.data;
            list.sort(function (a, b) {
              return b.value - a.value;
            });
            _this6.datasets.country = list;
          });
        }
      };
    });
  }

  function updateView() {
    module_default$2.data('update', function () {
      return {
        file: null,
        isProcessing: false,
        error: null,
        init: function init() {},
        filesize: function filesize$1() {
          return filesize(this.file.size);
        },
        submit: function submit() {
          var _this = this;
          return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
            var data, msg;
            return _regeneratorRuntime().wrap(function _callee$(_context) {
              while (1) switch (_context.prev = _context.next) {
                case 0:
                  if (!(!_this.file || _this.isProcessing)) {
                    _context.next = 2;
                    break;
                  }
                  return _context.abrupt("return");
                case 2:
                  _this.isProcessing = true;
                  data = new FormData();
                  data.append('file', _this.file);
                  _context.prev = 5;
                  _context.next = 8;
                  return api.post("/update", data);
                case 8:
                  toast.defer('Updated successfully!');
                  window.location.reload();
                  _context.next = 20;
                  break;
                case 12:
                  _context.prev = 12;
                  _context.t0 = _context["catch"](5);
                  msg = 'An unexpected error occurred! Please try again later!';
                  if (_context.t0.response && _context.t0.response.data.message) {
                    msg = _context.t0.response.data.message;
                  }
                  _this.isProcessing = false;
                  _this.error = msg;
                  window.modal.close();
                  return _context.abrupt("return");
                case 20:
                case "end":
                  return _context.stop();
              }
            }, _callee, null, [[5, 12]]);
          }))();
        }
      };
    });
  }

  function assistantView() {
    module_default$2.data('assistant', function (assistant) {
      return {
        assistant: {},
        model: {},
        isProcessing: false,
        init: function init() {
          this.assistant = assistant;
          this.model = _objectSpread2(_objectSpread2({}, this.model), this.assistant);
        },
        submit: function submit() {
          var _this = this;
          return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
            var data;
            return _regeneratorRuntime().wrap(function _callee$(_context) {
              while (1) switch (_context.prev = _context.next) {
                case 0:
                  if (!_this.isProcessing) {
                    _context.next = 2;
                    break;
                  }
                  return _context.abrupt("return");
                case 2:
                  _this.isProcessing = true;
                  data = _objectSpread2({}, _this.model);
                  data.status = _this.model.status ? 1 : 0;
                  if (!_this.model.file) {
                    _context.next = 10;
                    break;
                  }
                  _context.next = 8;
                  return _this.readFileAsBase64(_this.model.file);
                case 8:
                  data.avatar = _context.sent;
                  delete data.file;
                case 10:
                  _this.assistant.id ? _this.update(data) : _this.create(data);
                case 11:
                case "end":
                  return _context.stop();
              }
            }, _callee);
          }))();
        },
        update: function update(data) {
          var _this2 = this;
          api.patch("/assistants/".concat(this.assistant.id), data).then(function (response) {
            _this2.assistant = response.data;
            _this2.model = _objectSpread2({}, _this2.assistant);
            _this2.isProcessing = false;
            toast.success('Assistant has been updated successfully!');
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        },
        create: function create(data) {
          var _this3 = this;
          api.post('/assistants', data).then(function (response) {
            toast.defer('Assistant has been created successfully!');
            window.location = "/admin/assistants/";
          })["catch"](function (error) {
            return _this3.isProcessing = false;
          });
        },
        readFileAsBase64: function readFileAsBase64(file) {
          return new Promise(function (resolve, reject) {
            var reader = new FileReader();
            reader.onload = function (e) {
              var base64String = e.target.result.replace("data:", "").replace(/^.+,/, "");
              resolve(base64String);
            };
            reader.onerror = function (error) {
              reject(error);
            };
            reader.readAsDataURL(file);
          });
        }
      };
    });
  }

  function voiceView() {
    module_default$2.data('voice', function () {
      var voice = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      return {
        voice: voice,
        isProcessing: false,
        init: function init() {
          this.voice = voice;
        },
        submit: function submit(form) {
          var _this = this;
          return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
            var data;
            return _regeneratorRuntime().wrap(function _callee$(_context) {
              while (1) switch (_context.prev = _context.next) {
                case 0:
                  if (!_this.isProcessing) {
                    _context.next = 2;
                    break;
                  }
                  return _context.abrupt("return");
                case 2:
                  _this.isProcessing = true;
                  data = new CustomFormData(form);
                  _context.t0 = _this;
                  _context.next = 7;
                  return data.toJson();
                case 7:
                  _context.t1 = _context.sent;
                  _context.t0.update.call(_context.t0, _context.t1);
                case 9:
                case "end":
                  return _context.stop();
              }
            }, _callee);
          }))();
        },
        update: function update(data) {
          var _this2 = this;
          api.patch("/voices/".concat(this.voice.id), data).then(function (response) {
            _this2.voice = response.data;
            _this2.isProcessing = false;
            toast.success('Voice has been updated successfully!');
          })["catch"](function (error) {
            return _this2.isProcessing = false;
          });
        }
      };
    });
  }

  // Load views
  listView();
  dashboardView();
  presetView();
  userView();
  workspaceView();
  categoryView();
  planView();
  pluginsView();
  pluginView();
  subscriptionView();
  planSnapshowView();
  settingsView();
  updateView();
  assistantView();
  voiceView();

  // Call after views are loaded
  module_default$2.plugin(module_default$1);
  module_default$2.plugin(module_default.defaultProps({
    arrow: false
  }));
  module_default$2.start();

})();
//# sourceMappingURL=admin.js.map
