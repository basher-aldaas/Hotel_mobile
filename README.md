-php artisan serve
-npm run dev
-php artisan migrate
-php artisan db:seed
-php artisan schedule:run
-php artisan queue:run


🏨 هوتيل موبايل - Hotel Mobile
هوتيل موبايل هو نظام متكامل لإدارة الحجوزات الفندقية، يتكوّن من:
تطبيق موبايل للمستخدمين.
لوحة تحكم (Dashboard) للمشرفين.
يوفر النظام واجهات وصلاحيات مختلفة لكل من الأدمين والمستخدم النهائي، مع خصائص متقدمة لإدارة الحجوزات، الغرف، العروض، المستخدمين، والمعرض (Gallery)، إلى جانب بنية تقنية قوية تعتمد على Laravel وميزات أخرى حديثة.
👥 الشخصيات (Roles & Permissions)
✅ Admin
لديه صلاحيات كاملة على النظام، تشمل:
إدارة المستخدمين (CRUD)
إدارة الغرف، الحجوزات، العروض، المعرض (CRUD + Force Delete / Update دائمًا)
✅ User
يمتلك صلاحيات محدودة:
Booking: صلاحيات CRUD كاملة، لكن لا يمكنه تعديل أو حذف الحجز في حال تبقّى على موعد البدء أقل من يوم.
Users, Gallery, Rooms, Offers: صلاحيات مشاهدة فقط + حذف جزئي لبعض الموارد.
📱 تطبيق الموبايل (Mobile App)
يحتوي على:
لوحة تحكم خاصة بالمستخدم
Authentication:
تسجيل دخول / تسجيل حساب / تسجيل خروج
إعادة تعيين كلمة المرور
الملف الشخصي (Profile):
عرض بيانات المستخدم
تعديل البيانات
Booking:
إدارة كاملة للحجوزات
مشاهدة حجوزات لغرفة معيّنة
مشاهدة جميع الحجوزات
Gallery / Rooms / Offers:
عرض محتوى هذه الأقسام
🖥️ لوحة التحكم (Dashboard)
تتضمن 5 تبويبات رئيسية:
القسمالصلاحياتملاحظاتUsersCRUDللأدمين فقطGalleryCRUD + Force Delete / UpdateRoomsCRUD + Force Delete / UpdateBookingsCRUD + Force Delete / UpdateOffersCRUD + Force Delete / Update
⚙️ أهم التقنيات المستخدمة
✅ Laravel (كإطار عمل رئيسي)
✅ Filament Admin Dashboard
✅ Flutter (لواجهة الموبايل - إن وجدت)
✅ ERD (مخطط العلاقات مصمم مسبقًا)
✅ Naming Convention موحد
✅ Validation موحد عبر FormRequest
✅ Response/Request Classes موحدة
✅ نظام Roles & Permissions باستخدام باكج خارجي
✅ Indexing لتحسين أداء قواعد البيانات
✅ Reset Password Functionality
✅ Queue & Jobs للمهام غير المتزامنة (مثل الإيميلات والإشعارات)
✅ Transactions لحماية سلامة البيانات
✅ Model Middleware (Model Ware) لتنفيذ إجراءات تلقائية
✅ Force Delete وSoft Delete مدعومان
🛠️ التثبيت والتشغيل (Locally)
git clone https://github.com/your-username/hotel-mobile.git cd hotel-mobile composer install cp .env.example .env php artisan key:generate php artisan migrate --seed php artisan serve
🧪 بيانات تجريبية
Admin
📧 admin@example.com
🔑 password
User
📧 user@example.com
🔑 password
