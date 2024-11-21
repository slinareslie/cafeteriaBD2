function filterProducts() {
  const searchValue = document.getElementById("search-bar").value.toLowerCase();
  const products = document.querySelectorAll(".product-card");

  products.forEach((product) => {
    const productName = product.getAttribute("data-name").toLowerCase();
    if (productName.includes(searchValue)) {
      product.style.display = "block";
    } else {
      product.style.display = "none";
    }
  });
}

function showCategory(category) {
  const products = document.querySelectorAll(".product-card");

  products.forEach((product) => {
    const productCategory = product.getAttribute("data-category");
    if (productCategory === category || category === "all") {
      product.style.display = "block";
    } else {
      product.style.display = "none";
    }
  });

  // Actualiza las pestañas activas
  document.querySelectorAll(".tab-button").forEach((button) => {
    button.classList.remove("active");
  });
  const activeTab = Array.from(document.querySelectorAll(".tab-button")).find(
    (btn) => btn.textContent.toLowerCase().includes(category)
  );
  if (activeTab) {
    activeTab.classList.add("active");
  }
}

function sortProducts() {
  const sortValue = document.getElementById("sort-options").value;
  const productsContainer = document.getElementById("products-grid");
  const products = Array.from(productsContainer.children);

  if (sortValue === "asc") {
    products.sort(
      (a, b) =>
        parseFloat(a.getAttribute("data-price")) -
        parseFloat(b.getAttribute("data-price"))
    );
  } else if (sortValue === "desc") {
    products.sort(
      (a, b) =>
        parseFloat(b.getAttribute("data-price")) -
        parseFloat(a.getAttribute("data-price"))
    );
  }

  products.forEach((product) => productsContainer.appendChild(product));
}
