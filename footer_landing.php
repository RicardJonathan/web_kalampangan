    <!-- Footer -->
    <footer class="bg-gradient-to-br from-primary-800 to-primary-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="./images/logo/logo.png" alt="Logo" class="h-10 w-10">
                        <h3 class="text-xl font-bold">Kelurahan Kalampangan</h3>
                    </div>
                    <p class="mb-4 text-primary-200">
                        Membangun masyarakat yang sejahtera melalui pelayanan prima dan pemerintahan yang transparan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.instagram.com/kelurahankalampangan80?igsh=MXZ4dzE1djdybmN0OQ==" class="text-white hover:text-primary-300 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        
                        <a href="#" class="text-white hover:text-primary-300 transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Menu</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-primary-200 hover:text-white transition">Beranda</a></li>
                        <li><a href="berita_pengumuman.php" class="text-primary-200 hover:text-white transition">Berita & Pengumuman</a></li>
                        <li><a href="berita_kegiatan.php" class="text-primary-200 hover:text-white transition">Kegiatan</a></li>
                        <li><a href="tentang.php" class="text-primary-200 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="pengajuan.php" class="text-primary-200 hover:text-white transition">Pengajuan Online</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-300"></i>
                            <span class="text-primary-200">Jl. Kalampangan, Kec. Sabangau, Kota Palangka Raya</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-primary-300"></i>
                            <span class="text-primary-200">(0536) 421123</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary-300"></i>
                            <span class="text-primary-200">kelurahan.kalampangan@palangkaraya.go.id</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-primary-300"></i>
                            <span class="text-primary-200">Senin-Jumat: 08:00 - 15:30</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-primary-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-primary-300 text-sm mb-4 md:mb-0">
                        &copy; 2024 Kelurahan Kalampangan. Hak Cipta Dilindungi.
                    </p>
                    <div class="text-center">
                        <marquee behavior="scroll" direction="left" class="text-sm text-primary-300">
                            @kkn_mandiri_kalampangan | Website oleh Mahasiswa KKN-T Mandiri Kelompok 2 2025
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-gradient-to-r from-primary-500 to-secondary-500 text-white p-4 rounded-full shadow-xl opacity-0 invisible transition-all duration-300 hover:opacity-90">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        
        // Mobile Berita Toggle
        document.getElementById('berita-mobile-toggle').addEventListener('click', function() {
            const dropdown = document.getElementById('berita-mobile-dropdown');
            const arrow = document.getElementById('berita-mobile-arrow');
            
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });
        
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            const backToTop = document.getElementById('back-to-top');
            
            if (window.scrollY > 100) {
                navbar.classList.add('shadow-md');
                backToTop.classList.remove('opacity-0', 'invisible');
                backToTop.classList.add('opacity-100', 'visible');
            } else {
                navbar.classList.remove('shadow-md');
                backToTop.classList.add('opacity-0', 'invisible');
                backToTop.classList.remove('opacity-100', 'visible');
            }
        });
        
        // Back to Top Button
        document.getElementById('back-to-top').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Initialize Particles.js with a more subtle effect
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 10,
                    "density": {
                        "enable": true,
                        "value_area": 40
                    }
                },
                "color": {
                    "value": "#ff1414"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#ff1414"
                    }
                },
                "opacity": {
                    "value": 1,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 1,
                        "opacity_min": 0,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 2,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 200,
                    "color": "#ff1414",
                    "opacity": 0.1,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 0.5,
                    "direction": "none",
                    "random": true,
                    "straight": false,
                    "out_mode": "out"
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 200,
                        "line_linked": {
                            "opacity": 0.3
                        }
                    },
                    "push": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });

        // Scroll behavior for header
        let lastScroll = 0;
        const navbar = document.querySelector('nav');
        
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            // Hide/show navbar on scroll
            if (currentScroll <= 100) {
                // At top of page - always show
                navbar.classList.remove('transform', '-translate-y-full');
                navbar.classList.add('shadow-md');
            } else if (currentScroll > lastScroll && currentScroll > 100) {
                // Scrolling down - hide navbar
                navbar.classList.add('transform', '-translate-y-full');
            } else {
                // Scrolling up - show navbar
                navbar.classList.remove('transform', '-translate-y-full');
            }
            
            lastScroll = currentScroll;
            
            // Back to top button logic
            const backToTop = document.getElementById('back-to-top');
            if (currentScroll > 100) {
                backToTop.classList.remove('opacity-0', 'invisible');
                backToTop.classList.add('opacity-100', 'visible');
            } else {
                backToTop.classList.add('opacity-0', 'invisible');
                backToTop.classList.remove('opacity-100', 'visible');
            }
        });
    </script>
</body>
</html>