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
  const quantity = parseInt(quantityInput.value) || 1;

  if (!cart[productId]) {
    cart[productId] = { name, price, quantity: 0 };
  }

  cart[productId].quantity += quantity;
  updateCartUI();
}

function removeFromCart(productId) {
  if (cart[productId]) {
    delete cart[productId];
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
    item.innerHTML = `${product.name} (x${
      product.quantity
    }) - S/ ${productTotal.toFixed(2)}
      <button onclick="removeFromCart('${productId}')">Eliminar</button>`;
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
    if (e.target.checked) {
      addToCart(productId, name, price);
    } else {
      removeFromCart(productId);
    }
  });

  const quantityInput = card.querySelector(`#cantidad-${productId}`);
  quantityInput.addEventListener("change", (e) => {
    if (cart[productId]) {
      cart[productId].quantity = parseInt(e.target.value) || 1;
      updateCartUI();
    }
  });
});



document.getElementById("cart-button").addEventListener("click", toggleCart);


document.querySelector("form").addEventListener("submit", function (event) {
  const cartTotal = document.getElementById("cart-total").textContent;
  document.getElementById("cart-total-value").value = cartTotal;
});

function pasarDatosAlPedido() {
  const cartItems = document.getElementById("cart-items");
  const cartTotal = document.getElementById("cart-total").textContent;
  const items = [];
  cartItems.querySelectorAll(".cart-item").forEach((item) => {
    const name = item.querySelector(".item-name").textContent;
    const quantity = item.querySelector(".item-quantity").textContent;
    const price = item.querySelector(".item-price").textContent;

    items.push({ name, quantity, price });
  });
  const form = document.createElement("form");
  form.action = "index.php?controller=empleado&action=verPedido";
  form.method = "POST";
  const inputCartDetails = document.createElement("input");
  inputCartDetails.type = "hidden";
  inputCartDetails.name = "cart_details";
  inputCartDetails.value = JSON.stringify(items);
  const inputCartTotal = document.createElement("input");
  inputCartTotal.type = "hidden";
  inputCartTotal.name = "cart_total";
  inputCartTotal.value = cartTotal;
  form.appendChild(inputCartDetails);
  form.appendChild(inputCartTotal);
  document.body.appendChild(form);
  form.submit();
}

function updateDateTime() {
  const now = new Date();
  const options = {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
  };
  document.getElementById("current-datetime").textContent = now.toLocaleString(
    "es-ES",
    options
  );
}

setInterval(updateDateTime, 1000);
updateDateTime();

checkbox.addEventListener("change", function () {
  console.log("Checkbox cambiado:", checkbox.checked);
});

document.addEventListener("DOMContentLoaded", function () {
  const checkbox = document.getElementById("sin-datos-cliente");
  const camposAdicionales = document.getElementById("campos-adicionales");

  checkbox.addEventListener("change", function () {
    if (checkbox.checked) {
      camposAdicionales.style.display = "none";
    } else {
      camposAdicionales.style.display = "block";
    }
  });

  if (checkbox.checked) {
    camposAdicionales.style.display = "none";
  } else {
    camposAdicionales.style.display = "block";
  }
});

document.querySelector('form').addEventListener('submit', function(e) {
  e.preventDefault();
  alert('Reserva realizada con éxito.');
});
