<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
  <div class="container mt-5">
    <h1>Product List</h1>

    <div class="mb-3">
      <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">Add Product</button>
    </div>

    <!-- Product Table -->
    <table class="table table-bordered">
      <thead class="">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="product-table">
        <!-- Dynamic content will be inserted here -->
      </tbody>
    </table>
  </div>
  </div>



  <!-- Add Product Modal -->
  <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Product form for adding a new product -->
          <form id="add-product-form">
            <div class="form-group">
              <label for="product-name">Product Name</label>
              <input type="text" class="form-control" id="product-name" name="name" required>
            </div>
            <div class="form-group">
              <label for="product-price">Product Price</label>
              <input type="number" class="form-control" id="product-price" name="price" required>
            </div>
            <div class="form-group">
              <label for="product-description">Product Description</label>
              <input type="text" class="form-control" id="product-description" name="desc">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <!-- Push the buttons to the right -->
          <div class="ml-auto">
            <!-- Close button to dismiss the modal -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- Save button that submits the form -->
            <button type="submit" form="add-product-form" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Update Product Modal -->
  <div class="modal fade" id="updateProductModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form for updating a product -->
          <form id="update-product-form">
            <input type="hidden" id="update-product-id" name="id"> <!-- Hidden field for product ID -->
            <div class="form-group">
              <label for="update-product-name">Product Name</label>
              <input type="text" class="form-control" id="update-product-name" name="name" required>
            </div>
            <div class="form-group">
              <label for="update-product-price">Product Price</label>
              <input type="number" class="form-control" id="update-product-price" name="price" required>
            </div>
            <div class="form-group">
              <label for="update-product-description">Product Description</label>
              <input type="text" class="form-control" id="update-product-description" name="desc">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="ml-auto">
            <!-- Close button to dismiss the modal -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- Save button that submits the form -->
            <button type="submit" form="update-product-form" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this product?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirm-delete">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Script for function with data -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function loadProducts() {
        fetch("http://localhost/Lab09/get_products.php", {
            method: "GET",
          })
          .then((response) => response.json()) // Convert response to JSON
          .then((products) => {
            const productTable = document.getElementById("product-table");
            productTable.innerHTML = ""; // Clear existing content

            products.forEach((product) => {
              const row = `
          <tr>
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.price}</td>
            <td>${product.description}</td>
            <td>
              <button class="btn btn-info btn-sm update-product" data-id="${product.id}" >Update</button>
              <button class="btn btn-danger btn-sm delete-product" data-id="${product.id}">Delete</button>
            </td>
          </tr>
          `;
              productTable.innerHTML += row; // Append new rows
            });
          })
          .catch((error) => {
            console.error("Error loading products:", error);
          });
      }


      loadProducts();

      // Handle form submission to add a product
      const form = document.getElementById("add-product-form");
      form.addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent default form submission

        const formData = {
          name: document.getElementById("product-name").value,
          price: parseInt(document.getElementById("product-price").value),
          desc: document.getElementById("product-description").value
        };

        fetch("http://localhost/Lab09/add_product.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json", // Ensure the correct content type
            },
            body: JSON.stringify(formData), // Send JSON body
          })
          .then((response) => {
            if (response.ok) {
              // Close modal and reload products
              $("#addProductModal").modal("hide");
              loadProducts(); // Reload the table after adding a product
            } else {
              console.error("Error adding product:", response.status);
            }
          })
          .catch((error) => {
            console.error("Error adding product:", error);
          });
      });

      document.getElementById("product-table").addEventListener("click", function(e) {
        if (e.target.classList.contains("update-product")) {
          const productId = parseInt(e.target.dataset.id);
          fetch(`http://localhost/Lab09/get_product.php?id=${productId}`, {
              method: "GET",
            })
            .then((response) => response.json())
            .then((product) => {
              // Populate the update modal with the product data
              document.getElementById("update-product-id").value = product.id;
              document.getElementById("update-product-name").value = product.name;
              document.getElementById("update-product-price").value = product.price;
              document.getElementById("update-product-description").value = product.description;

              // Show the update modal
              $("#updateProductModal").modal("show");
            })
            .catch((error) => console.error("Error fetching product details:", error));
        }
      });

      // Handle form submission for updating a product
      document.getElementById("update-product-form").addEventListener("submit", function(e) {
        const formData = {
          id: parseInt(document.getElementById("update-product-id").value),
          name: document.getElementById("update-product-name").value,
          price: parseInt(document.getElementById("update-product-price").value),
          desc: document.getElementById("update-product-description").value,
        };

        fetch("http://localhost/Lab09/update_product.php", {
            method: "PUT",
            headers: {
              "Content-Type": "application/json", // Correct content type
            },
            body: JSON.stringify(formData), // Send JSON body
          })
          .then((response) => {
            if (response.ok) {
              loadProducts(); // Reload the product table
              // Close the update modal and reload products
              $("#updateProductModal").modal("hide");
            } else {
              console.error("Error updating product:", response.status);
            }
          })
          .catch((error) => console.error("Error updating product:", error));
      });

      // Handle click on "Delete" buttons to show the confirmation modal
      document.getElementById("product-table").addEventListener("click", function(e) {
        if (e.target.classList.contains("delete-product")) {
          productIdToDelete = parseInt(e.target.dataset.id); // Get the ID of the product to delete
          $("#deleteConfirmationModal").modal("show"); // Show the confirmation modal
        }
      });

      // Handle confirmation in the modal
      document.getElementById("confirm-delete").addEventListener("click", function() {
        // Delete the product after confirmation
        fetch(`http://localhost/Lab09/delete_product.php?id=${productIdToDelete}`, {
            method: "DELETE",
          })
          .then((response) => {
            if (response.ok) {
              $("#deleteConfirmationModal").modal("hide"); // Close the modal
              loadProducts(); // Reload the product table
            } else {
              console.error("Error deleting product:", response.status);
            }
          })
          .catch((error) => console.error("Error deleting product:", error));
      });

      // //Delete button
      // document.getElementById("product-table").addEventListener("click", function(e) {
      //   if (e.target.classList.contains("delete-product")) {
      //     const productId = parseInt(e.target.dataset.id);
      //     if (confirm("Are you sure you want to delete this product?")) {
      //       fetch(`http://localhost/Lab09/delete_product.php?id=${productId}`, {
      //           method: "DELETE",
      //         })
      //         .then((response) => {
      //           if (response.ok) {
      //             loadProducts(); // Reload the product table
      //           } else {
      //             console.error("Error deleting product:", response.status);
      //           }
      //         })
      //         .catch((error) => console.error("Error deleting product:", error));
      //     }

      //   }
      // });
    });
  </script>


  <!-- Bootstrap JS and Popper.js -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>