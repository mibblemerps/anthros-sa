function formConfirmations() {
    const forms = document.getElementsByTagName('form');
    for (const form of forms) {
        if (form.dataset.submitConfirmation) {
            form.onsubmit = (e) => {
                if (!confirm(form.dataset.submitConfirmation)) {
                    e.preventDefault();
                }
            };
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    formConfirmations();
});
