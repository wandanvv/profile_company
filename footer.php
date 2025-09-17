<style>
    footer { background: #333; color: white; text-align: center; padding: 30px 20px; }

footer p { margin: 5px 0; }
</style>
<footer>
    <p>&copy; 2025 LPK CTI. Semua Hak Dilindungi.</p>
    <p style="margin-top: 10px; font-size: 0.9rem; opacity: 0.8;">
      Lembaga Pelatihan Kerja Terakreditasi | TUK LSP IT dan Pemasaran
    </p>
  </footer>

  <script>
    // Smooth scrolling untuk navigasi
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>