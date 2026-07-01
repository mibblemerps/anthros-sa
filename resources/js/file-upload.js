export default class FileUpload {
    constructor(el) {
        this.el = el;

        el.addEventListener('click', (e) => {
            e.preventDefault();
            this.manualUpload();
        });

        el.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.el.classList.add('dragover');
        });

        el.addEventListener('dragleave', (e) => {
            // Prevent flickering when moving over child elements
            if (!this.el.contains(e.relatedTarget)) {
                this.el.classList.remove('dragover');
            }
        });

        el.addEventListener('drop', (e) => {
            e.preventDefault();
            e.stopPropagation();

            this.el.classList.remove('dragover');

            const files = e.dataTransfer.files;

            if (!files || files.length === 0) {
                return;
            }

            this.addFileInput(files);
            this.renderFiles(files); // <-- added
        });
    }

    createInput() {
        const input = document.createElement('input');

        input.name = 'photo[]';
        input.type = 'file';
        input.accept = 'image/*';
        input.style.display = 'none';

        return input;
    }

    addFileInput(files) {
        const input = this.createInput();

        // In most modern browsers this works directly
        try {
            input.files = files;
        } catch {
            // Fallback: rebuild a FileList using DataTransfer
            const dataTransfer = new DataTransfer();

            for (const file of files) {
                dataTransfer.items.add(file);
            }

            input.files = dataTransfer.files;
        }

        this.el.parentElement.appendChild(input);

        // Optional: dispatch change so other code can react consistently
        input.dispatchEvent(new Event('change', { bubbles: true }));
    }

    renderFiles(files) {
        const container = this.el.parentElement.querySelector('.files');
        if (!container) return;

        for (const file of files) {
            if (!file.type.startsWith('image/')) continue;

            const wrapper = document.createElement('div');

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);

            const span = document.createElement('span');
            span.textContent = file.name;

            wrapper.appendChild(img);
            wrapper.appendChild(span);

            container.appendChild(wrapper);
        }
    }

    manualUpload() {
        const input = this.createInput();

        input.addEventListener('change', () => {
            if (!input.files || input.files.length === 0) {
                input.remove();
                return;
            }

            this.renderFiles(input.files); // <-- added
        });

        input.addEventListener('cancel', (e) => {
            input.remove();
        });

        this.el.parentElement.appendChild(input);
        input.click();
    }
}
