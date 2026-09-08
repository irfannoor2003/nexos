</div><!-- /admin-content -->
</main><!-- /admin-main -->

<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');
const menuBtn = document.getElementById('menu-btn');
function openSidebar(){ sidebar?.classList.add('open'); overlay?.classList.add('show'); document.body.style.overflow='hidden'; }
function closeSidebar(){ sidebar?.classList.remove('open'); overlay?.classList.remove('show'); document.body.style.overflow=''; }
menuBtn?.addEventListener('click', function(e){
  e.stopPropagation();
  sidebar?.classList.contains('open') ? closeSidebar() : openSidebar();
});
overlay?.addEventListener('click', closeSidebar);
document.querySelectorAll('.admin-sidebar a').forEach(function(a){
  a.addEventListener('click', function(){ if(window.innerWidth < 901) closeSidebar(); });
});
</script>
</body>
</html>