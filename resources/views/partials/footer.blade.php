<!-- Footer -->
<style>
    /* Footer Styles */
    .footer {
        background: #3A5A40;
        color: white;
        padding: 3rem 0 1rem;
        margin-top: 4rem;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: block; /* Override any grid styles from other pages */
    }

    .footer-content {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .footer-section h3 {
        margin-bottom: 1rem;
        color: white;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .footer-section p {
        color: white;
        line-height: 1.6;
        font-size: 0.9rem;
    }

    .footer-section ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 0.75rem;
        color: white;
        font-size: 0.9rem;
    }

    .footer-section ul li a {
        color: white;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-section ul li a:hover {
        color: #ccc;
    }

    .footer-logo {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .footer-logo img {
        height: 60px;
        width: auto;
        margin-bottom: 1rem;
    }

    .footer-social-icons {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .footer-social-icons a {
        color: white;
        font-size: 1.5rem;
        text-decoration: none;
        transition: color 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
    }

    .footer-social-icons a:hover {
        color: #ccc;
        background: rgba(255, 255, 255, 0.2);
    }

    .footer-social-icons svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 1rem;
        text-align: center;
        color: white;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .footer-content {
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 2rem;
            text-align: center;
        }

        .footer-logo {
            align-items: center;
        }
    }
</style>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section footer-logo">
                <img src="{{ asset('images/admin/logo-upi.webp') }}" alt="UPI Logo">
                <p>Menyediakan pengalaman camping terbaik dengan fasilitas lengkap dan pemandangan alam yang menakjubkan di Bandung.</p>
                <div class="footer-social-icons">
                    <a href="#" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="mailto:info@upinaturecamp.com" aria-label="Email">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </a>
                    <a href="tel:+6212345678" aria-label="Phone">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                    <li><a href="{{ url('/booking') }}">Reservasi</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul>
                    <li>📧 info@upinaturecamp.com</li>
                    <li>📞 +62 123 456 789</li>
                    <li>📍 Bandung, Jawa Barat</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} UPI Nature Camp. All rights reserved.</p>
        </div>
    </div>
</footer>
