/*
 * Created on Thu Jan 20 2022
 *
 *  Devlan - devlan.co.ke
 *
 * hello@devlan.info
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2022 Devlan
 *
 * 1. GRANT OF LICENSE
 * Devlan hereby grants to you (an individual) the revocable, personal, non-exclusive, and nontransferable right to
 * install and activate this system on two separated computers solely for your personal and non-commercial use,
 * unless you have purchased a commercial license from Devlan. Sharing this Software with other individuals,
 * or allowing other individuals to view the contents of this Software, is in violation of this license.
 * You may not make the Software available on a network, or in any way provide the Software to multiple users
 * unless you have first purchased at least a multi-user license from Devlan.
 *
 * 2. COPYRIGHT
 * The Software is owned by Devlan and protected by copyright law and international copyright treaties.
 * You may not remove or conceal any proprietary notices, labels or marks from the Software.
 *
 * 3. RESTRICTIONS ON USE
 * You may not, and you may not permit others to
 * (a) reverse engineer, decompile, decode, decrypt, disassemble, or in any way derive source code from, the Software;
 * (b) modify, distribute, or create derivative works of the Software;
 * (c) copy (other than one back-up copy), distribute, publicly display, transmit, sell, rent, lease or
 * otherwise exploit the Software.
 *
 * 4. TERM
 * This License is effective until terminated.
 * You may terminate it at any time by destroying the Software, together with all copies thereof.
 * This License will also terminate if you fail to comply with any term or condition of this Agreement.
 * Upon such termination, you agree to destroy the Software, together with all copies thereof.
 *
 * 5. NO OTHER WARRANTIES.
 * Devlan  DOES NOT WARRANT THAT THE SOFTWARE IS ERROR FREE.
 * Devlan SOFTWARE DISCLAIMS ALL OTHER WARRANTIES WITH RESPECT TO THE SOFTWARE,
 * EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO IMPLIED WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT OF THIRD PARTY RIGHTS.
 * SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES OR LIMITATIONS
 * ON HOW LONG AN IMPLIED WARRANTY MAY LAST, OR THE EXCLUSION OR LIMITATION OF
 * INCIDENTAL OR CONSEQUENTIAL DAMAGES,
 * SO THE ABOVE LIMITATIONS OR EXCLUSIONS MAY NOT APPLY TO YOU.
 * THIS WARRANTY GIVES YOU SPECIFIC LEGAL RIGHTS AND YOU MAY ALSO
 * HAVE OTHER RIGHTS WHICH VARY FROM JURISDICTION TO JURISDICTION.
 *
 * 6. SEVERABILITY
 * In the event of invalidity of any provision of this license, the parties agree that such invalidity shall not
 * affect the validity of the remaining portions of this license.
 *
 * 7. NO LIABILITY FOR CONSEQUENTIAL DAMAGES IN NO EVENT SHALL DEVLAN  OR ITS SUPPLIERS BE LIABLE TO YOU FOR ANY
 * CONSEQUENTIAL, SPECIAL, INCIDENTAL OR INDIRECT DAMAGES OF ANY KIND ARISING OUT OF THE DELIVERY, PERFORMANCE OR
 * USE OF THE SOFTWARE, EVEN IF DEVLAN HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES
 * IN NO EVENT WILL DEVLAN  LIABILITY FOR ANY CLAIM, WHETHER IN CONTRACT
 * TORT OR ANY OTHER THEORY OF LIABILITY, EXCEED THE LICENSE FEE PAID BY YOU, IF ANY.
 */

(function ($) {
  "use strict";

  // the default editor for parsing and rendering
  var I18nEditor = function (props, element) {
    var locale = props.locale || "en-US";

    this.parse = function (customFormat) {
      var numberFormat = new Intl.NumberFormat(locale);
      var thousandSeparator =
        numberFormat.format(11111).replace(/1/g, "") || ".";
      var decimalSeparator = numberFormat.format(1.1).replace(/1/g, "");
      return parseFloat(
        customFormat
          .replace(new RegExp(" ", "g"), "")
          .replace(new RegExp("\\" + thousandSeparator, "g"), "")
          .replace(new RegExp("\\" + decimalSeparator), ".")
      );
    };

    this.render = function (number) {
      var decimals = parseInt(element.getAttribute("data-decimals")) || 0;
      var digitGrouping = !(
        element.getAttribute("data-digit-grouping") === "false"
      );
      var numberFormat = new Intl.NumberFormat(locale, {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals,
        useGrouping: digitGrouping,
      });
      return numberFormat.format(number);
    };
  };

  var triggerKeyPressed = false;
  var originalVal = $.fn.val;
  $.fn.val = function (value) {
    if (arguments.length >= 1) {
      for (var i = 0; i < this.length; i++) {
        if (this[i]["bootstrap-input-spinner"] && this[i].setValue) {
          this[i].setValue(value);
        }
      }
    }
    return originalVal.apply(this, arguments);
  };

  $.fn.inputSpinner = function (methodOrProps) {
    if (methodOrProps === "destroy") {
      this.each(function () {
        if (this["bootstrap-input-spinner"]) {
          this.destroyInputSpinner();
        } else {
          console.warn("element", this, "is no bootstrap-input-spinner");
        }
      });
      return this;
    }

    var props = {
      decrementButton: "<strong>&minus;</strong>", // button text
      incrementButton: "<strong>&plus;</strong>", // ..
      groupClass: "", // css class of the resulting input-group
      buttonsClass: "btn-outline-secondary",
      buttonsWidth: "2.5rem",
      textAlign: "center", // alignment of the entered number
      autoDelay: 500, // ms threshold before auto value change
      autoInterval: 50, // speed of auto value change, set to `undefined` to disable auto-change
      buttonsOnly: false, // set this `true` to disable the possibility to enter or paste the number via keyboard
      keyboardStepping: true, // set this to `false` to disallow the use of the up and down arrow keys to step
      locale: navigator.language, // the locale, per default detected automatically from the browser
      editor: I18nEditor, // the editor (parsing and rendering of the input)
      // the template of the input
      template:
        '<div class="input-group ${groupClass}">' +
        '<button style="min-width: ${buttonsWidth}" class="btn btn-decrement ${buttonsClass} btn-minus" type="button">${decrementButton}</button>' +
        '<input type="text" inputmode="decimal" style="text-align: ${textAlign}" class="form-control form-control-text-input"/>' +
        '<button style="min-width: ${buttonsWidth}" class="btn btn-increment ${buttonsClass} btn-plus" type="button">${incrementButton}</button>' +
        "</div>",
    };

    for (var option in methodOrProps) {
      // noinspection JSUnfilteredForInLoop
      props[option] = methodOrProps[option];
    }

    var html = props.template
      .replace(/\${groupClass}/g, props.groupClass)
      .replace(/\${buttonsWidth}/g, props.buttonsWidth)
      .replace(/\${buttonsClass}/g, props.buttonsClass)
      .replace(/\${decrementButton}/g, props.decrementButton)
      .replace(/\${incrementButton}/g, props.incrementButton)
      .replace(/\${textAlign}/g, props.textAlign);

    this.each(function () {
      if (this["bootstrap-input-spinner"]) {
        console.warn("element", this, "is already a bootstrap-input-spinner");
      } else {
        var $original = $(this);
        $original[0]["bootstrap-input-spinner"] = true;
        $original.hide();
        $original[0].inputSpinnerEditor = new props.editor(props, this);

        var autoDelayHandler = null;
        var autoIntervalHandler = null;

        var $inputGroup = $(html);
        var $buttonDecrement = $inputGroup.find(".btn-decrement");
        var $buttonIncrement = $inputGroup.find(".btn-increment");
        var $input = $inputGroup.find("input");
        var $label = $("label[for='" + $original.attr("id") + "']");
        if (!$label[0]) {
          $label = $original.closest("label");
        }

        var min = null;
        var max = null;
        var step = null;

        updateAttributes();

        var value = parseFloat($original[0].value);
        var pointerState = false;

        var prefix = $original.attr("data-prefix") || "";
        var suffix = $original.attr("data-suffix") || "";

        if (prefix) {
          var prefixElement = $(
            '<span class="input-group-text">' + prefix + "</span>"
          );
          $inputGroup.find("input").before(prefixElement);
        }
        if (suffix) {
          var suffixElement = $(
            '<span class="input-group-text">' + suffix + "</span>"
          );
          $inputGroup.find("input").after(suffixElement);
        }

        $original[0].setValue = function (newValue) {
          setValue(newValue);
        };
        $original[0].destroyInputSpinner = function () {
          destroy();
        };

        var observer = new MutationObserver(function () {
          updateAttributes();
          setValue(value, true);
        });
        observer.observe($original[0], { attributes: true });

        $original.after($inputGroup);

        setValue(value);

        $input
          .on("paste input change focusout", function (event) {
            var newValue = $input[0].value;
            var focusOut = event.type === "focusout";
            newValue = $original[0].inputSpinnerEditor.parse(newValue);
            setValue(newValue, focusOut);
            dispatchEvent($original, event.type);
          })
          .on("keydown", function (event) {
            if (props.keyboardStepping) {
              if (event.which === 38) {
                // up arrow pressed
                event.preventDefault();
                if (!$buttonDecrement.prop("disabled")) {
                  stepHandling(step);
                }
              } else if (event.which === 40) {
                // down arrow pressed
                event.preventDefault();
                if (!$buttonIncrement.prop("disabled")) {
                  stepHandling(-step);
                }
              }
            }
          })
          .on("keyup", function (event) {
            // up/down arrow released
            if (
              props.keyboardStepping &&
              (event.which === 38 || event.which === 40)
            ) {
              event.preventDefault();
              resetTimer();
            }
          });

        // decrement button
        onPointerDown($buttonDecrement[0], function () {
          if (!$buttonDecrement.prop("disabled")) {
            pointerState = true;
            stepHandling(-step);
          }
        });
        // increment button
        onPointerDown($buttonIncrement[0], function () {
          if (!$buttonIncrement.prop("disabled")) {
            pointerState = true;
            stepHandling(step);
          }
        });
        onPointerUp(document.body, function () {
          if (pointerState === true) {
            resetTimer();
            dispatchEvent($original, "change");
            pointerState = false;
          }
        });
      }

      function setValue(newValue, updateInput) {
        if (updateInput === undefined) {
          updateInput = true;
        }
        if (isNaN(newValue) || newValue === "") {
          $original[0].value = "";
          if (updateInput) {
            $input[0].value = "";
          }
          value = NaN;
        } else {
          newValue = parseFloat(newValue);
          newValue = Math.min(Math.max(newValue, min), max);
          $original[0].value = newValue;
          if (updateInput) {
            $input[0].value = $original[0].inputSpinnerEditor.render(newValue);
          }
          value = newValue;
        }
      }

      function destroy() {
        $original.prop("required", $input.prop("required"));
        observer.disconnect();
        resetTimer();
        $input.off("paste input change focusout");
        $inputGroup.remove();
        $original.show();
        $original[0]["bootstrap-input-spinner"] = undefined;
        if ($label[0]) {
          $label.attr("for", $original.attr("id"));
        }
      }

      function dispatchEvent($element, type) {
        if (type) {
          setTimeout(function () {
            var event;
            if (typeof Event === "function") {
              event = new Event(type, { bubbles: true });
            } else {
              // IE
              event = document.createEvent("Event");
              event.initEvent(type, true, true);
            }
            $element[0].dispatchEvent(event);
          });
        }
      }

      function stepHandling(step) {
        calcStep(step);
        resetTimer();
        if (props.autoInterval !== undefined) {
          autoDelayHandler = setTimeout(function () {
            autoIntervalHandler = setInterval(function () {
              calcStep(step);
            }, props.autoInterval);
          }, props.autoDelay);
        }
      }

      function calcStep(step) {
        if (isNaN(value)) {
          value = 0;
        }
        setValue(Math.round(value / step) * step + step);
        dispatchEvent($original, "input");
      }

      function resetTimer() {
        clearTimeout(autoDelayHandler);
        clearTimeout(autoIntervalHandler);
      }

      function updateAttributes() {
        // copy properties from original to the new input
        if ($original.prop("required")) {
          $input.prop("required", $original.prop("required"));
          $original.removeAttr("required");
        }
        $input.prop("placeholder", $original.prop("placeholder"));
        $input.attr("inputmode", $original.attr("inputmode") || "decimal");
        var disabled = $original.prop("disabled");
        var readonly = $original.prop("readonly");
        $input.prop("disabled", disabled);
        $input.prop("readonly", readonly || props.buttonsOnly);
        $buttonIncrement.prop("disabled", disabled || readonly);
        $buttonDecrement.prop("disabled", disabled || readonly);
        if (disabled || readonly) {
          resetTimer();
        }
        var originalClass = $original.prop("class");
        var groupClass = "";
        // sizing
        if (/form-control-sm/g.test(originalClass)) {
          groupClass = "input-group-sm";
        } else if (/form-control-lg/g.test(originalClass)) {
          groupClass = "input-group-lg";
        }
        var inputClass = originalClass.replace(/form-control(-(sm|lg))?/g, "");
        $inputGroup.prop(
          "class",
          "input-group " + groupClass + " " + props.groupClass
        );
        $input.prop("class", "form-control " + inputClass);

        // update the main attributes
        min =
          isNaN($original.prop("min")) || $original.prop("min") === ""
            ? -Infinity
            : parseFloat($original.prop("min"));
        max =
          isNaN($original.prop("max")) || $original.prop("max") === ""
            ? Infinity
            : parseFloat($original.prop("max"));
        step = parseFloat($original.prop("step")) || 1;
        if ($original.attr("hidden")) {
          $inputGroup.attr("hidden", $original.attr("hidden"));
        } else {
          $inputGroup.removeAttr("hidden");
        }
        if ($original.attr("id")) {
          $input.attr("id", $original.attr("id") + "_MP_cBdLN29i2");
          if ($label[0]) {
            $label.attr("for", $input.attr("id"));
          }
        }
      }
    });

    return this;
  };

  function onPointerUp(element, callback) {
    element.addEventListener("mouseup", function (e) {
      callback(e);
    });
    element.addEventListener("touchend", function (e) {
      callback(e);
    });
    element.addEventListener("keyup", function (e) {
      if (e.keyCode === 32 || e.keyCode === 13) {
        triggerKeyPressed = false;
        callback(e);
      }
    });
  }

  function onPointerDown(element, callback) {
    element.addEventListener("mousedown", function (e) {
      if (e.button === 0) {
        e.preventDefault();
        callback(e);
      }
    });
    element.addEventListener("touchstart", function (e) {
      if (e.cancelable) {
        e.preventDefault();
      }
      callback(e);
    });
    element.addEventListener("keydown", function (e) {
      if ((e.keyCode === 32 || e.keyCode === 13) && !triggerKeyPressed) {
        triggerKeyPressed = true;
        callback(e);
      }
    });
  }
})(jQuery);
