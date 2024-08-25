/*!
 * Built with http://stenciljs.com
 * 2018-06-29T13:20:28
 */

(function (window, document, resourcesUrl) {
  var ionicons = window.ionicons = window.ionicons || {};
  var components = ionicons.components = [
    ["ion-icon", "5nonw4yz", 1, [
      ["ariaLabel", 2, 1, "aria-label", 2],
      ["color", 1, 0, 1, 2],
      ["doc", 3, 0, 0, 0, "document"],
      ["el", 7],
      ["icon", 1, 0, 1, 2],
      ["ios", 1, 0, 1, 2],
      ["isServer", 3, 0, 0, 0, "isServer"],
      ["isVisible", 5],
      ["lazy", 1, 0, 1, 3],
      ["md", 1, 0, 1, 2],
      ["mode", 1, 0, 1, 2],
      ["name", 1, 0, 1, 2],
      ["resourcesUrl", 3, 0, 0, 0, "resourcesUrl"],
      ["size", 1, 0, 1, 2],
      ["src", 1, 0, 1, 2],
      ["svgContent", 5],
      ["win", 3, 0, 0, 0, "window"]
    ], 1]
  ];

  var hydratedStyles = components
    .filter(function (comp) { return comp[2]; })
    .map(function (comp) { return comp[0]; });

  if (hydratedStyles.length) {
    var styleEl = document.createElement("style");
    styleEl.innerHTML = hydratedStyles.join() + "{visibility:hidden}.hydrated{visibility:inherit}";
    styleEl.setAttribute("data-styles", "");
    document.head.insertBefore(styleEl, document.head.firstChild);
  }

  function initStencilApps(apps) {
    (window["s-apps"] = window["s-apps"] || []).push("ionicons");

    if (!initStencilApps.componentOnReady) {
      initStencilApps.componentOnReady = function () {
        var self = this;

        function componentOnReadyCallback(callback) {
          if (self.nodeName.indexOf("-") > 0) {
            var apps = window["s-apps"];
            for (var i = 0; i < apps.length; i++) {
              if (window[apps[i]].componentOnReady) {
                if (window[apps[i]].componentOnReady(self, callback)) {
                  return;
                }
              }
            }
            if (i < apps.length) {
              return;
            }
          }

          if (callback) {
            callback(null);
          }
        }

        return window.Promise ? new window.Promise(componentOnReadyCallback) : { then: componentOnReadyCallback };
      };
    }

    return initStencilApps;
  }

  var scripts = document.querySelectorAll("script");
  var lastScriptIndex = scripts.length - 1;

  for (var i = lastScriptIndex; i >= 0; i--) {
    var script = scripts[i];

    if (!script.src && !script.hasAttribute("data-resources-url")) {
      break;
    }

    var dataResourcesUrl = script.getAttribute("data-resources-url");

    if (!resourcesUrl && dataResourcesUrl) {
      resourcesUrl = dataResourcesUrl;
    }

    if (!resourcesUrl && script.src) {
      var srcArray = script.src.split("/").slice(0, -1);
      resourcesUrl = srcArray.join("/") + (srcArray.length ? "/" : "") + "ionicons/";
    }

    if (!resourcesUrl && script.src) {
      resourcesUrl = script.src.split("/").slice(0, -1).join("/") + "/";
    }
  }

  var scriptElement = document.createElement("script");

  if (window.customElements && window.customElements.define && window.fetch && window.CSS && window.CSS.supports && window.CSS.supports("color", "var(--c)") && "noModule" in scriptElement) {
    scriptElement.src = resourcesUrl + "ionicons.z18qlu2u.js";
  } else {
    scriptElement.src = resourcesUrl + "ionicons.suuqn5vt.js";
    scriptElement.type = "module";
    scriptElement.setAttribute("crossorigin", true);
  }

  scriptElement.setAttribute("data-resources-url", resourcesUrl);
  scriptElement.setAttribute("data-namespace", "ionicons");

  document.head.appendChild(scriptElement);
})(window, document);
