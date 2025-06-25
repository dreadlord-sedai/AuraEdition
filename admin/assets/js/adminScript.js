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
  event.preventDefault(); // Prevent form from submitting normally
  const modelName = document.getElementById("model_name").value;
  const makeId = document.getElementById("make_id").value;
  if (modelName.trim() === "" || makeId === "") {
    alert("Please enter a model name and select a make.");
    return false;
  }

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState === XMLHttpRequest.DONE) {
      if (request.status === 200) {
        alert("Model added successfully.");
        window.location.reload();
      } else {
        alert("Error adding model: " + request.responseText);
      }
    }
  };

  request.open(
    "POST",
    "/Projects/AuraEdition/admin/process/addModelProcess.php",
    true
  );
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send(
    "name=" + encodeURIComponent(modelName) + "&make_id=" + encodeURIComponent(makeId)
  );
  return false; // Prevent default form submission
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
