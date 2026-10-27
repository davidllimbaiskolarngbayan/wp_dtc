document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.dtc-contact-page .dtc-contact-digits').forEach(function (field) {
        const maxLength = field.name === 'phone' ? 11 : 4;

        field.inputMode = 'numeric';
        field.pattern = '[0-9]{' + maxLength + '}';
        field.maxLength = maxLength;
        field.addEventListener('input', function () {
            const digits = field.value.replace(/[^0-9]/g, '').slice(0, maxLength);
            if (field.value !== digits) {
                field.value = digits;
            }
        });
    });

    const contactForm = document.querySelector('.dtc-contact-page .wpcf7 form');
    if (contactForm) {
        const submitButton = contactForm.querySelector('input[type="submit"], button[type="submit"]');
        const validationErrors = new Map();
        let submissionInProgress = false;

        function getFieldError(name, fallbackMessage) {
            const field = Array.from(contactForm.elements).find(function (element) {
                return element.name === name;
            });
            const value = field && typeof field.value === 'string' ? field.value.trim() : '';
            const messages = {
                'first-name': 'Please enter your first name.',
                'last-name': 'Please enter your last name.',
                phone: value ? 'Please enter an 11-digit phone number using numbers only.' : 'Please enter your phone number.',
                postcode: value ? 'Please enter a 4-digit postcode using numbers only.' : 'Please enter your postcode.',
                'your-email': value ? 'Please enter a valid email address.' : 'Please enter your email address.',
                'your-subject': 'Please enter a subject.',
                'your-message': 'Please enter your question or comment.',
                'privacy-policy': 'Please agree to the Privacy Policy.'
            };

            return messages[name] || fallbackMessage;
        }

        function isFieldValid(name) {
            const field = Array.from(contactForm.elements).find(function (element) {
                return element.name === name;
            });

            if (!field) {
                return true;
            }

            if (name === 'privacy-policy') {
                return field.checked;
            }

            const value = field.value.trim();
            if (field.getAttribute('aria-required') === 'true' && value === '') {
                return false;
            }

            if (name === 'phone') {
                return /^[0-9]{11}$/.test(value);
            }

            if (name === 'postcode') {
                return /^[0-9]{4}$/.test(value);
            }

            if (name === 'your-email') {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) && field.checkValidity();
            }

            return field.checkValidity();
        }

        function updateSubmitState() {
            let hasInvalidFields = false;
            validationErrors.forEach(function (message, name) {
                const field = Array.from(contactForm.elements).find(function (element) {
                    return element.name === name;
                });
                const wrapper = field && field.closest('.wpcf7-form-control-wrap');

                if (!isFieldValid(name)) {
                    hasInvalidFields = true;
                    if (wrapper) {
                        wrapper.classList.add('wpcf7-not-valid');
                        field.classList.add('wpcf7-not-valid');
                        field.setAttribute('aria-invalid', 'true');
                        let tip = wrapper.querySelector('.wpcf7-not-valid-tip');
                        if (!tip) {
                            tip = document.createElement('span');
                            tip.className = 'wpcf7-not-valid-tip';
                            tip.setAttribute('aria-hidden', 'true');
                            wrapper.appendChild(tip);
                        }
                        tip.textContent = message;
                        wrapper.querySelectorAll('.wpcf7-not-valid-tip').forEach(function (duplicateTip) {
                            if (duplicateTip !== tip) {
                                duplicateTip.remove();
                            }
                        });
                    }
                } else if (wrapper) {
                    wrapper.querySelectorAll('.wpcf7-not-valid-tip').forEach(function (tip) {
                        tip.remove();
                    });
                    wrapper.classList.remove('wpcf7-not-valid');
                    wrapper.querySelectorAll('.wpcf7-not-valid').forEach(function (invalidControl) {
                        invalidControl.classList.remove('wpcf7-not-valid');
                        invalidControl.setAttribute('aria-invalid', 'false');
                        invalidControl.removeAttribute('aria-describedby');
                    });
                }
            });

            if (submitButton) {
                submitButton.disabled = submissionInProgress || hasInvalidFields;
            }
        }

        contactForm.addEventListener('submit', function (event) {
            if (submissionInProgress) {
                event.preventDefault();
                event.stopImmediatePropagation();
                return;
            }

            submissionInProgress = true;
            updateSubmitState();
        }, true);

        contactForm.addEventListener('wpcf7invalid', function (event) {
            const fields = event.detail && event.detail.apiResponse && event.detail.apiResponse.invalid_fields;
            if (!Array.isArray(fields) || fields.length === 0) {
                return;
            }

            validationErrors.clear();
            fields.forEach(function (field) {
                if (field && typeof field.field === 'string') {
                    validationErrors.set(field.field, getFieldError(field.field, field.message));
                }
            });
            window.setTimeout(updateSubmitState, 0);
        });

        contactForm.addEventListener('input', updateSubmitState);
        contactForm.addEventListener('change', updateSubmitState);
        contactForm.addEventListener('wpcf7submit', function () {
            submissionInProgress = false;
            updateSubmitState();
        });
        contactForm.addEventListener('wpcf7mailsent', function () {
            submissionInProgress = false;
            validationErrors.clear();
            updateSubmitState();
        });
        contactForm.addEventListener('wpcf7mailfailed', function () {
            submissionInProgress = false;
            validationErrors.clear();
            updateSubmitState();
        });

        const successModal = document.querySelector('#dtc-contact-success-modal');
        if (successModal) {
            const closeSuccessModal = successModal.querySelector('.dtc-contact-modal__close');
            let previousSuccessFocus = null;

            function hideSuccessModal() {
                successModal.hidden = true;
                document.body.classList.remove('dtc-contact-modal-open');
                if (previousSuccessFocus) {
                    previousSuccessFocus.focus();
                }
            }

            contactForm.addEventListener('wpcf7mailsent', function () {
                previousSuccessFocus = document.activeElement;
                successModal.hidden = false;
                document.body.classList.add('dtc-contact-modal-open');
                closeSuccessModal.focus();
            });

            closeSuccessModal.addEventListener('click', hideSuccessModal);
            successModal.addEventListener('click', function (event) {
                if (event.target === successModal) {
                    hideSuccessModal();
                }
            });
            successModal.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    hideSuccessModal();
                }
            });
        }
    }

    const privacyLink = document.querySelector('.dtc-contact-page .dtc-contact-privacy-link');
    if (!privacyLink) {
        return;
    }

    const modal = document.querySelector('#dtc-contact-privacy-modal');
    if (!modal) {
        console.error('Privacy Policy modal content is missing from the Contact Us page.');
        privacyLink.addEventListener('click', function (event) {
            event.preventDefault();
        });
        return;
    }

    const closeButton = modal.querySelector('.dtc-privacy-modal__close');
    let previousFocus = null;

    function closeModal() {
        modal.hidden = true;
        document.body.classList.remove('dtc-privacy-modal-open');
        if (previousFocus) {
            previousFocus.focus();
        }
    }

    privacyLink.addEventListener('click', function (event) {
        event.preventDefault();
        previousFocus = document.activeElement;
        modal.hidden = false;
        document.body.classList.add('dtc-privacy-modal-open');
        closeButton.focus();
    });

    closeButton.addEventListener('click', closeModal);
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    modal.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
            return;
        }

        if (event.key === 'Tab') {
            const focusable = Array.from(modal.querySelectorAll('a[href], button:not([disabled]), [tabindex="0"]'))
                .filter(function (element) {
                    return !element.hasAttribute('hidden');
                });
            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });
});