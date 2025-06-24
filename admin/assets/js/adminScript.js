document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar'); // Make sure your sidebar has this ID

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('hidden');
        });
    }
});

// Dynamic Model Dropdown for Edit Product
const makeSelect = document.getElementById('make');
const modelSelect = document.getElementById('model');
if (makeSelect && modelSelect) {
    makeSelect.addEventListener('change', function () {
        const makeId = this.value;
        modelSelect.innerHTML = '<option>Loading...</option>';
        fetch('/Projects/AuraEdition/admin/process/getModelsByMake.php?make_id=' + makeId)
            .then(response => response.json())
            .then(data => {
                modelSelect.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(function (model) {
                        const option = document.createElement('option');
                        option.value = model.model_id;
                        option.textContent = model.model_name;
                        modelSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.textContent = 'No models found';
                    modelSelect.appendChild(option);
                }
            });
    });
}