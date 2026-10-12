(function ($) {
    'use strict';

    if (!$) {
        if (window.console) { console.warn('address-country-phone.js: jQuery not loaded'); }
        return;
    }

    // Select the phone-code option that belongs to a country. Matched by country
    // NAME (data-country on each option), never by the code value, because several
    // countries share one calling code (+1, +44, +7). Setting .val() by the code
    // string would be ambiguous when duplicates exist - it just picks whichever
    // matching option is first in the list - so the exact <option> found is
    // selected directly instead.
    function setCodeForCountry($code, countryName) {
        var $target = $code.find('option').filter(function () {
            return $(this).attr('data-country') === countryName;
        }).first();

        if ($target.length && !$target.prop('selected')) {
            $code.find('option').prop('selected', false);
            $target.prop('selected', true);
        }
    }

    function initGroup($scope, group) {
        var $country = $scope.find('select[data-rage-country][data-rage-group="' + group + '"]');
        var $main    = $scope.find('select[data-rage-code="main"][data-rage-group="' + group + '"]');
        var $alt     = $scope.find('select[data-rage-code="alt"][data-rage-group="' + group + '"]');

        if (!$country.length || $country.data('rageReady')) { return; }
        $country.data('rageReady', true);

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
                $country.val(countryName);
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