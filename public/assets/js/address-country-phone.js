
(function ($) {
    'use strict';

    if (!$ || !$.fn || !$.fn.select2) {
        if (window.console) { console.warn('address-country-phone.js: jQuery / Select2 not loaded'); }
        return;
    }

    var codeOptions = {
        width: '70px',
        minimumResultsForSearch: 0,   // always show the search box
        dropdownAutoWidth: true,      // open list isn't squeezed into the 70px box
        templateSelection: function (option) {
            // Collapsed box shows only "+91"; the open list shows "+91 (India)"
            return (option.text || '').split(' ')[0] || option.text;
        }
    };

    // Inside a Bootstrap modal the dropdown has to live in the modal, otherwise
    // its search box can't take focus.
    function withParent($sel, options) {
        var $modal = $sel.closest('.modal');
        return $.extend({}, options, { dropdownParent: $modal.length ? $modal : $(document.body) });
    }

    // Select the phone-code option that belongs to a country. Matched by country
    // NAME (data-country), never by the code value, because several countries
    // share one calling code (+1, +44, +7). Only Select2's display is refreshed
    // ('change.select2'), so the handlers below can't trigger each other.
    function setCodeForCountry($code, countryName) {
        var $target = $code.find('option').filter(function () {
            return $(this).attr('data-country') === countryName;
        }).first();

        if ($target.length && !$target.prop('selected')) {
            $code.find('option').prop('selected', false);
            $target.prop('selected', true);
            $code.trigger('change.select2');
        }
    }

    function initGroup($scope, group) {
        var $country = $scope.find('select[data-rage-country][data-rage-group="' + group + '"]');
        var $main    = $scope.find('select[data-rage-code="main"][data-rage-group="' + group + '"]');
        var $alt     = $scope.find('select[data-rage-code="alt"][data-rage-group="' + group + '"]');

        if (!$country.length || $country.data('rageReady')) { return; }
        $country.data('rageReady', true);

        $country.select2(withParent($country, { width: '100%', minimumResultsForSearch: 0 }));
        $main.select2(withParent($main, codeOptions));
        $alt.select2(withParent($alt, codeOptions));

        // Country changed -> both phone codes follow it
        $country.on('change', function () {
            var countryName = $(this).val();
            setCodeForCountry($main, countryName);
            setCodeForCountry($alt, countryName);
        });

        // Mobile phone code changed -> Country (and the alternative code) follow it
        $main.on('change', function () {
            var countryName = $(this).find(':selected').attr('data-country');
            if (countryName && $country.val() !== countryName) {
                $country.val(countryName).trigger('change.select2');
                setCodeForCountry($alt, countryName);
            }
        });
    }

    function init(root) {
        var $root = root ? $(root) : $(document);

        $root.find('select[data-rage-country]').each(function () {
            var $sel = $(this);
            var $scope = $sel.closest('form');
            initGroup($scope.length ? $scope : $(document), $sel.attr('data-rage-group'));
        });
    }

    window.AddressCountryPhone = { init: init };

    // Form already on the page at load
    $(function () { init(); });

    // Form added later (the AJAX-loaded address modal)
    function holdsCountrySelect(node) {
        return node.nodeType === 1 &&
            (node.matches('select[data-rage-country]') || node.querySelector('select[data-rage-country]'));
    }

    if (window.MutationObserver) {
        new MutationObserver(function (mutations) {
            for (var i = 0; i < mutations.length; i++) {
                for (var j = 0; j < mutations[i].addedNodes.length; j++) {
                    if (holdsCountrySelect(mutations[i].addedNodes[j])) { init(); return; }
                }
            }
        }).observe(document.body, { childList: true, subtree: true });
    }
})(window.jQuery); 
