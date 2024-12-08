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
  if (!cart[productId]) {
    cart[productId] = { name, price, quantity: 1 };
  } else {
    cart[productId].quantity += 1;
  }
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
  cartItems.innerHTML = '';  // Limpiar el contenido actual

  for (const [productId, product] of Object.entries(cart)) {
    const listItem = document.createElement('li');
    listItem.textContent = `${product.name} - S/${product.price} x ${product.quantity}`;
    cartItems.appendChild(listItem);
  }
}

document.querySelectorAll('.producto-checkbox').forEach((checkbox) => {
  checkbox.addEventListener('change', (e) => {
    const productId = e.target.getAttribute('data-id');
    const productName = e.target.getAttribute('data-name');
    const productPrice = parseFloat(e.target.getAttribute('data-price'));

    if (e.target.checked) {
      addToCart(productId, productName, productPrice);
    } else {
      removeFromCart(productId);
    }
  });
});


document.getElementById("cart-button").addEventListener("click", toggleCart);

document.querySelector("form").addEventListener("submit", function (event) {
  const cartTotal = document.getElementById("cart-total").textContent;
  document.getElementById("cart-total-value").value = cartTotal;
});





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

