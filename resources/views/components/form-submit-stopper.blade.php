<script>
(function () {
    if (window.__formSubmitStopperInstalled) {
        return;
    }
    window.__formSubmitStopperInstalled = true;

    const FORM_SUBMITTING_ATTR = 'data-form-submitting';
    const ORIGINAL_LABEL_ATTR = 'data-original-submit-label';

    function setLoadingLabel(control, form) {
        if (!control) return;

        const customLabel = control.getAttribute('data-loading-text');
        const formLabel = form ? form.getAttribute('data-loading-text') : null;
        const loadingText = customLabel || formLabel || 'Processing...';

        if (control.tagName === 'BUTTON') {
            if (!control.hasAttribute(ORIGINAL_LABEL_ATTR)) {
                control.setAttribute(ORIGINAL_LABEL_ATTR, control.innerHTML);
            }
            control.innerHTML = loadingText;
            return;
        }

        if (control.tagName === 'INPUT' && (control.type === 'submit' || control.type === 'button')) {
            if (!control.hasAttribute(ORIGINAL_LABEL_ATTR)) {
                control.setAttribute(ORIGINAL_LABEL_ATTR, control.value);
            }
            control.value = loadingText;
        }
    }

    function lockSubmitControl(control, form) {
        if (!control) return;

        setLoadingLabel(control, form);
        control.disabled = true;
        control.setAttribute('aria-disabled', 'true');
        control.style.pointerEvents = 'none';
        control.style.opacity = '0.7';
    }

    function unlockSubmitControl(control) {
        if (!control) return;

        control.disabled = false;
        control.removeAttribute('aria-disabled');
        control.style.pointerEvents = '';
        control.style.opacity = '';

        if (!control.hasAttribute(ORIGINAL_LABEL_ATTR)) {
            return;
        }

        const originalLabel = control.getAttribute(ORIGINAL_LABEL_ATTR);
        if (control.tagName === 'BUTTON') {
            control.innerHTML = originalLabel;
        } else if (control.tagName === 'INPUT' && (control.type === 'submit' || control.type === 'button')) {
            control.value = originalLabel;
        }
        control.removeAttribute(ORIGINAL_LABEL_ATTR);
    }

    document.addEventListener('submit', function (event) {
        const form = event.target;
        if (!form || form.tagName !== 'FORM') return;

        if (form.getAttribute(FORM_SUBMITTING_ATTR) === '1') {
            event.preventDefault();
            event.stopPropagation();
            return;
        }

        setTimeout(function () {
            if (event.defaultPrevented) return;

            form.setAttribute(FORM_SUBMITTING_ATTR, '1');
            form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (control) {
                lockSubmitControl(control, form);
            });
        }, 0);
    }, true);

    window.addEventListener('pageshow', function () {
        document.querySelectorAll('form[' + FORM_SUBMITTING_ATTR + '="1"]').forEach(function (form) {
            form.removeAttribute(FORM_SUBMITTING_ATTR);
            form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (control) {
                unlockSubmitControl(control);
            });
        });
    });
})();
</script>