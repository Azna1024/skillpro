// SkillPro Institute - Main JS

document.addEventListener("DOMContentLoaded", function() {
  
  // Auto-hide Bootstrap alerts after 4 seconds
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.classList.add('fade');
      alert.classList.remove('show');
      setTimeout(() => alert.remove(), 500);
    }, 4000);
  });

  // Confirm before deletion links
  const deleteLinks = document.querySelectorAll('a.btn-danger');
  deleteLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      const confirmed = confirm("Are you sure you want to delete this item?");
      if (!confirmed) {
        e.preventDefault();
      }
    });
  });

});
