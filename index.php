<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopify</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

  <style>
    .swiper-container {
      width: 100%;
      height: 100%;
    }

    .fade-in {
      animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .hover-scale {
      transition: transform 0.3s ease-in-out;
    }

    .hover-scale:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<?php
session_start();
?>

<body class="bg-gray-100 font-sans">
  <header class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
      <a href="#" class="text-2xl font-bold text-yellow-500 hover:text-yellow-600 transition duration-300">
        <i class="fas fa-store mr-2"></i>Shopify
      </a>
      <nav class="hidden md:flex space-x-6">
        <a href="#about" class="text-gray-600 hover:text-yellow-500 transition duration-300">About</a>
        <a href="#product" class="text-gray-600 hover:text-yellow-500 transition duration-300">Products</a>
        <a href="#testimoni" class="text-gray-600 hover:text-yellow-500 transition duration-300">Testimonials</a>
        <a href="#contact" class="text-gray-600 hover:text-yellow-500 transition duration-300">Contact</a>
      </nav>
      <div class="flex items-center space-x-4">
        <?php if (isset($_SESSION['username'])): ?>
          <!-- Jika pengguna sudah login -->
          <?php if ($_SESSION['role'] == 'user'): ?>
            <a href="user/user_dashboard.php"
               class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300">
              <i class="fas fa-shopping-cart mr-2"></i>Shop
            </a>
          <?php elseif ($_SESSION['role'] == 'admin'): ?>
            <a href="admin_dashboard.php"
               class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300">
              <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
          <?php endif; ?>
        <?php else: ?>
          <!-- Jika pengguna belum login -->
          <a href="login.php"
             class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300">
            <i class="fas fa-sign-in-alt mr-2"></i>Login
          </a>
          <a href="register.php"
             class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
            <i class="fas fa-user-plus mr-2"></i>Register
          </a>
        <?php endif; ?>
      </div>
    </div>
  </header>


  <section id="home" class="h-screen relative overflow-hidden">
    <div class="swiper-container h-full">
      <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <div class="swiper-slide bg-cover bg-center" style="background-image: url('image/cooking3.jpg');">
          <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center p-4 md:p-8 lg:p-12 animate__animated animate__fadeIn">
              <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Welcome to Shopify</h1>
              <p class="text-xl md:text-2xl text-white mb-8">Discover delicious food and quality ingredients</p>
              <a href="#product"
                class="bg-yellow-500 text-black px-6 py-3 rounded-lg hover:bg-yellow-600 transition duration-300 animate__animated animate__bounceIn">
                <i class="fas fa-shopping-cart mr-2"></i>Shop Now
              </a>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide bg-cover bg-center" style="background-image: url('image/brownies.jpg');">
          <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center p-4 md:p-8 lg:p-12 animate__animated animate__fadeIn">
              <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Sweet Treats Await</h1>
              <p class="text-xl md:text-2xl text-white mb-8">Indulge in our range of desserts</p>
              <a href="#product"
                class="bg-yellow-500 text-black px-6 py-3 rounded-lg hover:bg-yellow-600 transition duration-300 animate__animated animate__bounceIn">
                <i class="fas fa-shopping-cart mr-2"></i>Shop Now
              </a>
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide bg-cover bg-center" style="background-image: url('image/cooking1.webp');">
          <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center p-4 md:p-8 lg:p-12 animate__animated animate__fadeIn">
              <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Fresh Ingredients</h1>
              <p class="text-xl md:text-2xl text-white mb-8">Quality ingredients for your kitchen</p>
              <a href="#product"
                class="bg-yellow-500 text-black px-6 py-3 rounded-lg hover:bg-yellow-600 transition duration-300 animate__animated animate__bounceIn">
                <i class="fas fa-shopping-cart mr-2"></i>Shop Now
              </a>
            </div>
          </div>
        </div>

        <!-- Slide 4 -->
        <div class="swiper-slide bg-cover bg-center" style="background-image: url('image/cooking2.jpg');">
          <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center p-4 md:p-8 lg:p-12 animate__animated animate__fadeIn">
              <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Delicious Meals</h1>
              <p class="text-xl md:text-2xl text-white mb-8">Experience the best meals prepared with love</p>
              <a href="#product"
                class="bg-yellow-500 text-black px-6 py-3 rounded-lg hover:bg-yellow-600 transition duration-300 animate__animated animate__bounceIn">
                <i class="fas fa-shopping-cart mr-2"></i>Shop Now
              </a>
            </div>
          </div>
        </div>

        <!-- Slide 5 -->
        <div class="swiper-slide bg-cover bg-center" style="background-image: url('image/segar3.jpg');">
          <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
            <div class="text-center p-4 md:p-8 lg:p-12 animate__animated animate__fadeIn">
              <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">Join Our Cooking Classes</h1>
              <p class="text-xl md:text-2xl text-white mb-8">Learn the art of cooking with our expert chefs</p>
              <a href="#product"
                class="bg-yellow-500 text-black px-6 py-3 rounded-lg hover:bg-yellow-600 transition duration-300 animate__animated animate__bounceIn">
                <i class="fas fa-shopping-cart mr-2"></i>Shop Now
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </section>

  <section id="about" class="py-20 bg-white">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-12">Why Choose Shopify?</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 hover-scale">
          <i class="fas fa-leaf text-4xl text-yellow-500 mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Fresh Ingredients</h3>
          <p class="text-gray-600">We use fresh, locally-sourced ingredients to ensure the best quality and taste.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 hover-scale">
          <i class="fas fa-utensils text-4xl text-yellow-500 mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Expert Chefs</h3>
          <p class="text-gray-600">Our experienced chefs create delicious dishes with passion and expertise.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 hover-scale">
          <i class="fas fa-truck text-4xl text-yellow-500 mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Fast Delivery</h3>
          <p class="text-gray-600">Enjoy quick and reliable delivery service right to your doorstep.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="product" class="py-20 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Our Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            include 'config.php'; // Pastikan untuk menyertakan file konfigurasi database
            
            // SQL untuk mengambil maksimal 4 produk
            $sql = "SELECT * FROM products LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Menampilkan setiap produk
                    $imagePath = 'products/' . $row["image"]; // Path gambar

                    // Debugging: Cek apakah file gambar ada
                    if (!file_exists($imagePath)) {
                        echo "<p class='text-red-500'>Gambar tidak ditemukan: " . $imagePath . "</p>"; // Pesan error
                        $imagePath = 'image/default_image.jpg'; // Gambar default jika tidak ada
                    }

                    echo '<div class="bg-white rounded-lg shadow-md overflow-hidden hover:scale-105 transition duration-300">';
                    echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row["name"]) . '" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src=\'image/default_image.jpg\'">';
                    echo '<div class="p-4">';
                    echo '<h3 class="text-xl font-semibold mb-2">' . htmlspecialchars($row["name"]) . '</h3>';
                    echo '<p class="text-gray-600 mb-4">' . htmlspecialchars($row["description"]) . '</p>';
                    echo '<div class="flex justify-between items-center">';
                    echo '<span class="text-yellow-500 font-bold">$' . htmlspecialchars($row["price"]) . '</span>';
                    echo '<button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-300">';
                    echo '<i class="fas fa-cart-plus mr-2"></i>Add to Cart</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-gray-600 text-center col-span-4">No products available.</p>';
            }

            $conn->close(); // Menutup koneksi database
            ?>
        </div>
    </div>
</section>


<section id="testimoni" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Customer Testimonials</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Testimonial 1 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="image/1.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold">John Doe</h4>
                        <div class="text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"Amazing food and great service! Will definitely order again."</p>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="image/4.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold">Jane Smith</h4>
                        <div class="text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"The ambiance was wonderful, and the food was delicious!"</p>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="image/2.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold">Michael Johnson</h4>
                        <div class="text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"Best dining experience I've had in a long time!"</p>
            </div>

            <!-- Testimonial 4 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="image/5.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold">Emily Davis</h4>
                        <div class="text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"Incredible flavors and the presentation was beautiful!"</p>
            </div>

            <!-- Testimonial 5 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="image/3.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold">Daniel Brown</h4>
                        <div class="text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"I can't wait to come back for more!"</p>
            </div>

            <!-- Testimonial 6 -->
            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <div class="flex items-center mb-4">
                    <img src="image/6.jpg" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold">Sarah Wilson</h4>
                        <div class="text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"A delightful experience with friends! Highly recommend!"</p>
            </div>
        </div>
    </div>
</section>

  <section id="contact" class="py-20 bg-gradient-to-r from-gray-100 via-yellow-50 to-gray-100">
    <div class="container mx-auto px-4">
      <h2 class="text-5xl font-bold text-center mb-12 text-gray-800">Contact Us</h2>
      <div class="flex flex-col lg:flex-row">
        <!-- Contact Form -->
        <form class="max-w-lg mx-auto bg-white p-10 rounded-lg shadow-lg lg:mr-8 lg:w-1/2 flex-1" id="contact-form">
          <div class="mb-6">
            <input
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent shadow-sm transition duration-300 hover:shadow-md"
              type="text" placeholder="Name" required>
          </div>
          <div class="mb-6">
            <input
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent shadow-sm transition duration-300 hover:shadow-md"
              type="email" placeholder="Email" required>
          </div>
          <div class="mb-6">
            <textarea
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent shadow-sm transition duration-300 hover:shadow-md"
              rows="6" placeholder="Message" required></textarea>
          </div>
          <button type="submit"
            class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
            <i class="fas fa-paper-plane mr-2"></i>Send Message
          </button>
        </form>

        <!-- Google Maps -->
        <div class="w-full lg:w-1/2 flex-1 mt-8 lg:mt-0">
          <div class="h-full">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345088686!2d144.9537353153185!3d-37.81720997975181!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f85c02f%3A0x7c4f8b3355f36c92!2sYour%20Location!5e0!3m2!1sen!2sus!4v1632237081861!5m2!1sen!2sus"
              width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </section>




  <footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
      <div class="flex flex-wrap justify-between">
        <div class="w-full md:w-1/4 mb-6 md:mb-0">
          <h3 class="text-xl font-semibold mb-4">Shopify</h3>
          <p class="text-gray-400">Bringing delicious food to your doorstep.</p>
        </div>
        <div class="w-full md:w-1/4 mb-6 md:mb-0">
          <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li><a href="#home" class="text-gray-400 hover:text-yellow-500 transition duration-300">Home</a></li>
            <li><a href="#about" class="text-gray-400 hover:text-yellow-500 transition duration-300">About</a></li>
            <li><a href="#product" class="text-gray-400 hover:text-yellow-500 transition duration-300">Products</a></li>
            <li><a href="#contact" class="text-gray-400 hover:text-yellow-500 transition duration-300">Contact</a></li>
          </ul>
        </div>
        <div class="w-full md:w-1/4 mb-6 md:mb-0">
          <h3 class="text-xl font-semibold mb-4">Follow Us</h3>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-300"><i
                class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-300"><i
                class="fab fa-twitter"></i></a>
            <a href="#" class="text-gray-400 hover:text-yellow-500 transition duration-300"><i
                class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      <hr class="border-gray-700 my-8">
      <p class="text-center text-gray-400">&copy; 2024 Shopify. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/swiper/8.4.5/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

  <script>
    // Initialize Swiper
    var swiper = new Swiper('.swiper-container', {
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      autoplay: {
        delay: 5000,
      },
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });

    // Form submission handling
    document.getElementById('contact-form').addEventListener('submit', function (e) {
      e.preventDefault();
      // Here you would typically send the form data to your server
      alert('Thank you for your message. We will get back to you soon!');
      this.reset();
    });

    // Add fade-in effect to sections as they come into view
    const sections = document.querySelectorAll('section');
    const options = {
      root: null,
      threshold: 0.1,
      rootMargin: "0px"
    };

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('fade-in');
          observer.unobserve(entry.target);
        }
      });
    }, options);

    sections.forEach(section => {
      observer.observe(section);
    });
  </script>
</body>

</html>