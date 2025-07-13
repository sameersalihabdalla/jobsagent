<?php
$page_title = "اتصل بنا";
include 'includes/header.php';
?>
<h3>اتصل بنا</h3>
<p>إذا كان لديك أي استفسار أو اقتراح، لا تتردد في التواصل معنا عبر النموذج التالي:</p>
<form method="POST" action="mailto:admin@jobsagent.org" class="row g-3">
  <div class="col-md-6"><input name="name" class="form-control" placeholder="الاسم" required></div>
  <div class="col-md-6"><input name="email" class="form-control" placeholder="البريد الإلكتروني" required></div>
  <div class="col-12"><textarea name="message" class="form-control" rows="5" placeholder="رسالتك" required></textarea></div>
  <div class="col-12"><button class="btn btn-primary w-100">إرسال</button></div>
</form>
<?php include 'includes/footer.php'; ?>
