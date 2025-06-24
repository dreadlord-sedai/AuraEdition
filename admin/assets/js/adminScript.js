document.addEventListener("DOMContentLoaded", function () {
  const toggleBtn = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("adminSidebar"); // Make sure your sidebar has this ID

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener("click", function () {
      sidebar.classList.toggle("hidden");
    });
  }
});

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

function addMake() {
  const makeName = document.getElementById("makeName").value;
  if (makeName.trim() === "") {
    alert("Please enter a make name.");
    return;
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState === XMLHttpRequest.DONE) {
      if (request.status === 200) {
        alert("Make added successfully.");
        window.location.reload(); // Reload the page to reflect changes
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
}

/* Category Management */
