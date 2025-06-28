document.addEventListener("DOMContentLoaded", function () {
  // Sidebar toggle functionality
  const toggleBtn = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("adminSidebar");

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener("click", function () {
      sidebar.classList.toggle("hidden");
    });
  }

  // Initialize user management functionality if on users page
  if (document.getElementById('usersTable')) {
    initializeUserManagement();
  }
});

/**
 * Initialize user management functionality
 */
function initializeUserManagement() {
  const searchInput = document.getElementById('search');
  const roleSelect = document.getElementById('role');
  const statusSelect = document.getElementById('status');
  
  // Add event listeners for search and filter inputs
  if (searchInput) searchInput.addEventListener('input', filterUsers);
  if (roleSelect) roleSelect.addEventListener('change', filterUsers);
  if (statusSelect) statusSelect.addEventListener('change', filterUsers);
  
  // Add event delegation for status toggle and delete buttons
  document.addEventListener('click', function(event) {
    // Handle status toggle
    if (event.target.closest('button[name="toggle_status"]')) {
      const button = event.target.closest('button[name="toggle_status"]');
      const form = button.closest('form');
      const statusInput = form.querySelector('input[name="status"]');
      
      // Toggle status for visual feedback before form submission
      const newStatus = statusInput.value === 'active' ? 'inactive' : 'active';
      statusInput.value = newStatus;
      
      // Update button appearance
      button.className = `px-2 py-1 text-xs rounded-full font-medium ${
        newStatus === 'active' 
          ? 'bg-green-100 text-green-800 hover:bg-green-200' 
          : 'bg-red-100 text-red-800 hover:bg-red-200'
      }`;
      button.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
      
      // Submit the form
      form.submit();
    }
  });
}

/**
 * Filter users based on search and filter inputs
 */
function filterUsers() {
  const searchTerm = document.getElementById('search').value.toLowerCase();
  const roleFilter = document.getElementById('role').value;
  const statusFilter = document.getElementById('status').value;
  const rows = document.querySelectorAll('#usersTable tbody tr');
  
  rows.forEach(row => {
    const name = row.querySelector('td:nth-child(2) .text-sm').textContent.toLowerCase();
    const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
    const role = row.querySelector('td:nth-child(4) span').textContent.toLowerCase();
    const status = row.querySelector('td:nth-child(5) button').textContent.toLowerCase();
    
    const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
    const matchesRole = !roleFilter || role === roleFilter.toLowerCase();
    const matchesStatus = !statusFilter || status === statusFilter.toLowerCase();
    
    row.style.display = (matchesSearch && matchesRole && matchesStatus) ? '' : 'none';
  });
}

// Dynamic Model Dropdown for Edit Product
const makeSelect = document.getElementById("make");
const modelSelect = document.getElementById("model");
if (makeSelect && modelSelect) {
  makeSelect.addEventListener("change", function () {
    const makeId = this.value;
    modelSelect.innerHTML = "<option>Loading...</option>";
    fetch(
      "/Projects/AuraEdition/admin/process/getModelsByMake.php?make_id=" +
        makeId
    )
      .then((response) => response.json())
      .then((data) => {
        modelSelect.innerHTML = "";
        if (data.length > 0) {
          data.forEach(function (model) {
            const option = document.createElement("option");
            option.value = model.model_id;
            option.textContent = model.model_name;
            modelSelect.appendChild(option);
          });
        } else {
          const option = document.createElement("option");
          option.textContent = "No models found";
          modelSelect.appendChild(option);
        }
      });
  });
}

//DELETE PRODUCT
function deleteProduct(productId) {
  if (confirm("Are you sure you want to delete this product?")) {
    var request = new XMLHttpRequest();
    request.open(
      "POST",
      "/Projects/AuraEdition/admin/process/deleteProductProcess.php",
      true
    );
    request.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );
    request.send("id=" + encodeURIComponent(productId));
    request.onreadystatechange = function () {
      if (request.readyState === XMLHttpRequest.DONE) {
        if (request.status === 200) {
          alert("Product deleted successfully.");
          window.location.reload(); // Reload the page to reflect changes
        } else {
          alert("Error deleting product: " + request.responseText);
        }
      }
    };
  }
}

/* Category Management */

function addMake(event) {
  event.preventDefault(); // Prevent form from submitting normally
  const makeName = document.getElementById("make_name").value;
  if (makeName.trim() === "") {
    alert("Please enter a make name.");
    return false;
  }

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState === XMLHttpRequest.DONE) {
      if (request.status === 200) {
        alert("Make added successfully.");
        window.location.reload();
      } else {
        alert("Error adding make: " + request.responseText);
      }
    }
  };

  request.open(
    "POST",
    "/Projects/AuraEdition/admin/process/addMakeProcess.php",
    true
  );
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send("name=" + encodeURIComponent(makeName));
  return false; // Prevent default form submission
}


function addModel(event) {
  event.preventDefault();
  const modelName = document.getElementById('model_name').value.trim();
  const makeId = document.getElementById('make_id').value;
  if (!modelName || !makeId) {
    alert('Please enter a model name and select a make.');
    return false;
  }
  fetch('/Projects/AuraEdition/admin/process/addModelProcess.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'name=' + encodeURIComponent(modelName) + '&make_id=' + encodeURIComponent(makeId)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      window.location.reload();
    } else {
      alert(data.message);
    }
  })
  .catch(() => {
    alert('An error occurred while adding the model.');
  });
  return false;
}

function deleteMake(makeId) {
  if (confirm("Are you sure you want to delete this make?")) {
    var request = new XMLHttpRequest();
    request.open(
      "POST",
      "/Projects/AuraEdition/admin/process/deleteMakeProcess.php",
      true
    );
    request.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );
    request.send("id=" + encodeURIComponent(makeId));
    request.onreadystatechange = function () {
      if (request.readyState === XMLHttpRequest.DONE) {
        if (request.status === 200) {
          alert("Make deleted successfully.");
          window.location.reload(); // Reload the page to reflect changes
        } else {
          alert("Error deleting make: " + request.responseText);
        }
      }
    };
  }
}

function deleteModel(modelId) {
  if (confirm("Are you sure you want to delete this model?")) {
    var request = new XMLHttpRequest();
    request.open(
      "POST",
      "/Projects/AuraEdition/admin/process/deleteModelProcess.php",
      true
    );
    request.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );
    request.send("id=" + encodeURIComponent(modelId));
    request.onreadystatechange = function () {
      if (request.readyState === XMLHttpRequest.DONE) {
        if (request.status === 200) {
          alert("Model deleted successfully.");
          window.location.reload(); // Reload the page to reflect changes
        } else {
          alert("Error deleting model: " + request.responseText);
        }
      }
    };
  }
}


/* Category Management */
