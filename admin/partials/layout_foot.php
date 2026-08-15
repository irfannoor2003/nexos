  </div><!-- /admin-content -->
</main><!-- /admin-main -->

<script>
// Mobile sidebar toggle
document.querySelector('.admin-topbar')?.addEventListener('click', function(e) {
  if (e.target.closest('.menu-btn')) document.getElementById('sidebar').classList.toggle('open');
});
// Close sidebar on outside click
document.addEventListener('click', function(e) {
  const sb = document.getElementById('sidebar');
  if (window.innerWidth < 900 && sb?.classList.contains('open') && !sb.contains(e.target)) {
    sb.classList.remove('open');
  }
});
</script>
</body>
</html>
