<!DOCTYPE html>
<html>
<head>
    <title>إضافة أخصائي جديد</title>
</head>
<body>
<form action="/add" method="POST">
    @csrf
    <label for="name">الاسم:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="email">البريد الإلكتروني:</label>
    <input type="email" id="email" name="email" required><br><br>
    <button type="submit">إرسال</button>
</form>
</body>
</html>
