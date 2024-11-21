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

let cart = {};

function toggleCart() {
  const modal = document.getElementById("cart-modal");
  modal.classList.toggle("hidden");
  updateCartUI();
}

function addToCart(productId, name, price) {
  const quantityInput = document.querySelector(`#cantidad-${productId}`);
  const quantity = parseInt(quantityInput.value) || 1; // Lee la cantidad, por defecto 1

  if (!cart[productId]) {
    cart[productId] = { name, price, quantity: 0 };
  }

  cart[productId].quantity += quantity; // Suma la cantidad seleccionada
  updateCartUI();
}

function removeFromCart(productId) {
  if (cart[productId]) {
    cart[productId].quantity--;
    if (cart[productId].quantity <= 0) {
      delete cart[productId];
      const checkbox = document.querySelector(
        `.product-card input[type="checkbox"][value="${productId}"]`
      );
      if (checkbox) {
        checkbox.checked = false;
      }
    }
  }
  updateCartUI();
}

function updateCartUI() {
  const cartItems = document.getElementById("cart-items");
  const cartTotal = document.getElementById("cart-total");

  cartItems.innerHTML = "";
  let total = 0;

  for (let productId in cart) {
    const product = cart[productId];
    const productTotal = product.price * product.quantity;
    total += productTotal;

    const item = document.createElement("p");
    item.innerHTML = `
            ${product.name} (x${product.quantity}) 
            - S/ ${productTotal.toFixed(2)}
            <button onclick="removeFromCart('${productId}')">Eliminar</button>
        `;
    cartItems.appendChild(item);
  }

  cartTotal.textContent = total.toFixed(2);
}

document.querySelectorAll(".product-card").forEach((card) => {
  const checkbox = card.querySelector("input[type='checkbox']");
  const productId = checkbox.value;
  const name = card.querySelector("h3").textContent;
  const price = parseFloat(card.getAttribute("data-price"));

  checkbox.addEventListener("change", (e) => {
    const quantityInput = card.querySelector(`#cantidad-${productId}`);
    const quantity = parseInt(quantityInput.value) || 1;

    if (e.target.checked) {
      if (!cart[productId]) {
        cart[productId] = { name, price, quantity: 0 };
      }
      cart[productId].quantity += quantity;
    } else {
      removeFromCart(productId);
    }
    updateCartUI();
  });

  // Actualiza la cantidad al cambiarla directamente en el input
  const quantityInput = card.querySelector(`#cantidad-${productId}`);
  quantityInput.addEventListener("change", (e) => {
    if (cart[productId]) {
      cart[productId].quantity = parseInt(e.target.value) || 1;
      updateCartUI();
    }
  });
});

document.getElementById("cart-button").addEventListener("click", toggleCart);
