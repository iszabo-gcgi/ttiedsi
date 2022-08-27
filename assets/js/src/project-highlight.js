// Polyfill for IE
// https://tc39.github.io/ecma262/#sec-array.prototype.find
if (!Array.prototype.find) {
  Object.defineProperty(Array.prototype, 'find', {
    value: function(predicate) {
      // 1. Let O be ? ToObject(this value).
      if (this == null) {
        throw TypeError('"this" is null or not defined');
      }

      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If IsCallable(predicate) is false, throw a TypeError exception.
      if (typeof predicate !== 'function') {
        throw TypeError('predicate must be a function');
      }

      // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
      var thisArg = arguments[1];

      // 5. Let k be 0.
      var k = 0;

      // 6. Repeat, while k < len
      while (k < len) {
        // a. Let Pk be ! ToString(k).
        // b. Let kValue be ? Get(O, Pk).
        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
        // d. If testResult is true, return kValue.
        var kValue = o[k];
        if (predicate.call(thisArg, kValue, k, o)) {
          return kValue;
        }
        // e. Increase k by 1.
        k++;
      }

      // 7. Return undefined.
      return undefined;
    },
    configurable: true,
    writable: true
  });
}

jQuery(function($) {
	if (!$('.project-groups').length) { return; }
	var categories = $(".project-groups .group");
	var projects = $(".projects .project");

	var groups = [];
	var currentclass = '';

	categories.each(function(index) {
		$(this).on("mouseenter click", function(event) {

			categories.each(function(m) {
				$(this).removeClass('active');
				console.log(categories[m].classList[2])

				$.each(groups, (function(k) {
					currentclass = categories[m].classList[2]
					// currentclass = groups[k];

					//if (that.hasClass(currentclass)) {
						projects.removeClass('active');
					//}
				}));
			});

			$(this).addClass('active');

			that = $(this);

			$.each(groups, (function(j) {
				// currentclass = groups[j];
				projects.removeClass('active');
				if (that.hasClass(currentclass)) {
					$(".projects .project" + "." + currentclass).addClass('active');
				}
			}));
		});
	});

	var allTabs = document.querySelectorAll('.tab');
	allTabs.forEach(function(tab){
	  tab.addEventListener('click',function(){

	    var iWasActive = tab.classList.contains('active');

	    //unactivate all the .active things
	    var activeTab = document.querySelector('.tab.active');
	    if (activeTab) { activeTab.classList.remove('active'); }
	    var activePanel = document.querySelector('.panel.active');
	    if (activePanel) { activePanel.classList.remove('active'); }

		var classListArray = Array.prototype.slice.call(tab.classList);
		 var panelClassWithLeadingDot = classListArray
	      .find(function(className) {
	        return className.match(/panel-/);
	      })
	      .replace(/panel-/,'.');

	    var myPanel = document.querySelector(panelClassWithLeadingDot);

	     if (iWasActive) {
	      tab.classList.remove('active');
	      myPanel.classList.remove('active');
	     }
	    else {
	      tab.classList.add('active');
	      myPanel.classList.add('active');
	    }

	  });
	});
});