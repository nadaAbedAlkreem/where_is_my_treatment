<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>أين علاجي؟ - تطبيق العثور على العيادات والخدمات الطبية</title>

    <!-- ======= Google Font =======-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet">
    <!-- End Google Font-->

    <!-- ======= Styles =======-->
    <link href="assets/vendors/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendors/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/vendors/glightbox/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendors/aos/aos.css" rel="stylesheet">
    <!-- End Styles-->
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />


    <!-- ======= Theme Style =======-->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- تعديل اتجاه الصفحة للغة العربية -->
    <style>
        .hero__app-img {
            width: 100%;              /* تأكد أن الصورة تمتد بعرض الحاوية */
            max-height: 400px;        /* تحدد أقصى ارتفاع عشان ما تكبرش زيادة */
            object-fit: cover;        /* تقص الصورة بحيث تغطي المساحة بشكل جميل */
            border-radius: 15px;      /* حواف دائرية ناعمة تعطي شكل راقي */
            box-shadow: 0 8px 20px rgba(0,0,0,0.2); /* ظل خفيف يعطي إحساس بالعمق */
            transition: transform 0.3s ease;  /* لتحريك بسيط عند التفاعل */
        }
        .col-lg-6.position-relative {
            display: flex;
            justify-content: center;  /* توسيط الصورة أفقياً */
            align-items: center;      /* توسيط الصورة رأسياً لو في ارتفاع معين */
            padding: 15px;            /* مساحة حول الصورة */
            background-color: #f9f9f9; /* لون خلفية ناعم يبرز الصورة */
            border-radius: 15px;      /* حواف ناعمة للحاوية */
        }


        .hero__app-img:hover {
            transform: scale(1.05);   /* تكبير بسيط عند المرور فوق الصورة */
        }

        body {
            direction: rtl;
            text-align: right;
            font-family: 'Inter', sans-serif;
        }
        /* تعديل اتجاه القوائم والتنقل */
        .navbar-nav .nav-link {
            text-align: right;
        }
        /* يمكن إضافة المزيد من التعديلات حسب الحاجة */
    </style>

    <!-- ======= Apply theme =======-->
    <script>
        // تطبيق الثيم بأسرع وقت لتجنب الوميض
        (function() {
            const storedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', storedTheme);
        })();
    </script>
</head>
<body>

<!-- ======= Site Wrap =======-->
<div class="site-wrap">

    <!-- ======= Header =======-->
    <header class="fbs__net-navbar navbar navbar-expand-lg dark" aria-label="freebootstrap.net navbar">
        <div class="container d-flex align-items-center justify-content-between">

            <!-- شعار التطبيق -->
            <a class="navbar-brand w-auto" href="index.html">
                <img class="logo dark img-fluid" src="assets/images/logo-dark.svg" alt="شعار أين علاجي؟">
                <img class="logo light img-fluid" src="assets/images/logo-light.svg" alt="شعار أين علاجي؟">
            </a>

            <!-- القائمة الجانبية -->
            <div class="offcanvas offcanvas-start w-75" id="fbs__net-navbars" tabindex="-1" aria-labelledby="fbs__net-navbarsLabel">
                <div class="offcanvas-header">
                    <div class="offcanvas-header-logo">
                        <a class="logo-link" id="fbs__net-navbarsLabel" href="index.html">
                            <img class="logo dark img-fluid" src="assets/images/logo-dark.svg" alt="شعار أين علاجي؟">
                            <img class="logo light img-fluid" src="assets/images/logo-light.svg" alt="شعار أين علاجي؟">
                        </a>
                    </div>
                    <button class="btn-close btn-close-black" type="button" data-bs-dismiss="offcanvas" aria-label="إغلاق"></button>
                </div>

                <div class="offcanvas-body align-items-lg-center">
                    <ul class="navbar-nav nav me-auto ps-lg-5 mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link scroll-link active" aria-current="page" href="#home">الرئيسية</a></li>
                        <li class="nav-item"><a class="nav-link scroll-link" href="#about">من نحن</a></li>
                        <li class="nav-item"><a class="nav-link scroll-link" href="#pricing">الاسئلة المتكررة</a></li>
                        <li class="nav-item"><a class="nav-link scroll-link" href="#how-it-works">كيف يعمل التطبيق</a></li>
                     </ul>
                </div>
            </div>

            <!-- زر القائمة -->
            <div class="ms-auto w-auto">
                <div class="header-social d-flex align-items-center gap-1">
                    <a class="btn btn-primary py-2" href="#sub" > اشترك  الان في تطبيقنا </a>
                    <button class="fbs__net-navbar-toggler justify-content-center align-items-center ms-auto" data-bs-toggle="offcanvas" data-bs-target="#fbs__net-navbars" aria-controls="fbs__net-navbars" aria-label="تبديل القائمة" aria-expanded="false">
                        <svg class="fbs__net-icon-menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" x2="21" y1="6" y2="6"></line>
                            <line x1="3" x2="15" y1="12" y2="12"></line>
                            <line x1="3" x2="17" y1="18" y2="18"></line>
                        </svg>
                        <svg class="fbs__net-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 6L18 18"></path>
                            <path d="M18 6L6 18"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <!-- نهاية الهيدر-->

    <!-- ======= Main =======-->
    <main>

        <!-- ======= القسم الرئيسي (الهيرو) =======-->
        <section class="hero__v6 section" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="row">
                            <div class="col-lg-11">
                                <span class="hero-subtitle text-uppercase" data-aos="fade-up" data-aos-delay="0">تطبيق أين علاجي؟</span>
                                <h1 class="hero-title mb-3" data-aos="fade-up" data-aos-delay="100">اعثر على علاجك في اقرب صيدلية لك بسرعة </h1>
                                <p class="hero-description mb-4 mb-lg-5" data-aos="fade-up" data-aos-delay="200">نوفر لك منصة سهلة الاستخدام للبحث عن العيادات،  ، والصيدليات بالقرب منك، مع تقييمات حقيقية وتجربة مستخدم مميزة.</p>
                                <div class="cta d-flex gap-2 mb-4 mb-lg-5" data-aos="fade-up" data-aos-delay="300">
                                    <a class="btn" href="#sub">اشترك  الان في تطبيقنا </a>
                                    <a class="btn btn-white-outline" href="#">تعرف أكثر
                                        <svg class="lucide lucide-arrow-up-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="17" x2="7" y1="7" y2="17"></line>
                                            <polyline points="7 7 17 7 17 17"></polyline>
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 position-relative">
                        <img src="assets/images/Pharmacist Giving Medicine To Customer Stock Image - Image of medicament, care_ 169280029.jpeg"
                             class="hero__app-img img-fluid"
                             alt="تطبيق أين علاجي؟"
                             data-aos="fade-up"
                             data-aos-delay="400"
                             data-aos-duration="800">

                    </div>
                </div>
            </div>
        </section>

        <!-- ======= قسم من نحن =======-->
        <section class="section bg-light" id="about">
            <div class="container">
                <h2 class="section-title mb-3 text-center">من نحن</h2>
                <p class="section-description text-center mb-5">تطبيق أين علاجي؟ هو منصة ذكية تسهل عليك الوصول إلى أفضل الخدمات الطبية في منطقتك. نحن نؤمن بأن الصحة أولاً، ونسعى لجعل البحث عن العناية الصحية تجربة سلسة ومريحة.</p>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <h3>سهولة الاستخدام</h3>
                        <p>واجهة بسيطة وسريعة تساعدك على إيجاد العيادة أو الطبيب في دقائق.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <h3>تقييمات موثوقة</h3>
                        <p>تعرف على آراء المرضى الآخرين قبل اختيارك للخدمة.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <h3>دعم متواصل</h3>
                        <p>فريقنا جاهز لمساعدتك في أي وقت على مدار الساعة.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= كيف يعمل التطبيق =======-->
        <section class="section howitworks__v1" id="how-it-works">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-6 text-center mx-auto">
                        <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">كيف يعمل التطبيق</span>
                        <h2 data-aos="fade-up" data-aos-delay="100">كيف يعمل تطبيق أين علاجي؟</h2>
                        <p data-aos="fade-up" data-aos-delay="200">
                            منصتنا مصممة لتسهيل العثور على العيادة أو الطبيب المناسب بسرعة وسهولة. اتبع هذه الخطوات البسيطة للبدء:
                        </p>
                    </div>
                </div>
                <div class="row g-md-5">
                    <div class="col-md-6 col-lg-3">
                        <div class="step-card text-center h-100 d-flex flex-column justify-content-start position-relative" data-aos="fade-up" data-aos-delay="0">
                            <div data-aos="fade-right" data-aos-delay="500">
                                <img class="arch-line" src="assets/images/arch-line.svg" alt="أيقونة خطوة التسجيل">
                            </div>
                            <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">1</span>
                            <div>
                                <h3 class="fs-5 mb-4">سجّل حسابك</h3>
                                <p>قم بزيارة موقعنا أو حمل التطبيق وسجل حسابك بسهولة بإدخال المعلومات الأساسية لإنشاء حساب آمن.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
                        <div class="step-card reverse text-center h-100 d-flex flex-column justify-content-start position-relative">
                            <div data-aos="fade-right" data-aos-delay="1100">
                                <img class="arch-line reverse" src="assets/images/arch-line-reverse.svg" alt="أيقونة خطوة إعداد الملف الشخصي">
                            </div>
                            <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">2</span>
                            <h3 class="fs-5 mb-4">أكمل ملفك الشخصي</h3>
                            <p>أضف بياناتك الشخصية أو معلومات عملك لتخصيص تجربة البحث حسب احتياجاتك.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="1200">
                        <div class="step-card text-center h-100 d-flex flex-column justify-content-start position-relative">
                            <div data-aos="fade-right" data-aos-delay="1700">
                                <img class="arch-line" src="assets/images/arch-line.svg" alt="أيقونة خطوة استكشاف المميزات">
                            </div>
                            <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">3</span>
                            <h3 class="fs-5 mb-4">اكتشف المميزات</h3>
                            <p>تصفح لوحة التحكم الخاصة بك للاطلاع على العيادات، الأطباء، الصيدليات القريبة، وتقييمات المستخدمين.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="1800">
                        <div class="step-card last text-center h-100 d-flex flex-column justify-content-start position-relative">
                            <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">4</span>
                            <div>
                                <h3 class="fs-5 mb-4">احصل على العلاج المناسب</h3>
                                <p>اختر العيادة أو الطبيب المناسب بناءً على تقييمات المستخدمين واحجز موعدك بسهولة وأمان.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- نهاية كيف يعمل التطبيق -->

        <!-- ======= الإحصائيات =======-->
        <section class="stats__v3 section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap content rounded-4" data-aos="fade-up" data-aos-delay="0">
                            <div class="rounded-borders">
                                <div class="rounded-border-1"></div>
                                <div class="rounded-border-2"></div>
                                <div class="rounded-border-3"></div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="100">
                                <div class="stat-item">
                                    <h3 class="fs-1 fw-bold">
                                        <span class="purecounter" data-purecounter-start="0" data-purecounter-end="5000" data-purecounter-duration="2">0</span><span>+</span>
                                    </h3>
                                    <p class="mb-0">مستخدم راضٍ عن خدماتنا</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="200">
                                <div class="stat-item">
                                    <h3 class="fs-1 fw-bold">
                                        <span class="purecounter" data-purecounter-start="0" data-purecounter-end="15000" data-purecounter-duration="2">0</span><span>+</span>
                                    </h3>
                                    <p class="mb-0">عمليات بحث ناجحة عن العلاجات</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="300">
                                <div class="stat-item">
                                    <h3 class="fs-1 fw-bold">
                                        <span class="purecounter" data-purecounter-start="0" data-purecounter-end="1200" data-purecounter-duration="2">0</span><span>+</span>
                                    </h3>
                                    <p class="mb-0">مركز طبي وشريك صحي متعاون</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- نهاية الإحصائيات -->

        <!-- ======= الأسئلة المتكررة =======-->
        <section class="section faq__v2" id="pricing">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-6 col-lg-7 mx-auto text-center">
                        <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">الأسئلة المتكررة</span>
                        <h2 class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">أسئلة شائعة حول تطبيق أين علاجي</h2>
                        <p data-aos="fade-up" data-aos-delay="100">نساعدك على إيجاد أفضل الخيارات للعلاج الطبي والصيدليات القريبة منك بسهولة وسرعة.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mx-auto" data-aos="fade-up" data-aos-delay="200">
                        <div class="faq-content">
                            <div class="accordion custom-accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                            ما هي الخدمات التي يقدمها تطبيق أين علاجي؟
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseOne">
                                        <div class="accordion-body">
                                            يوفر تطبيق أين علاجي خدمة البحث عن المستشفيات، العيادات، والصيدليات القريبة من موقعك، بالإضافة إلى معلومات حول الأطباء والتخصصات الطبية، ومواعيد الحجز بسهولة ويسر.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                            هل يمكنني حجز موعد من خلال التطبيق؟
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="panelsStayOpen-collapseTwo">
                                        <div class="accordion-body">
                                            نعم، يمكنك حجز موعد في العيادات والمستشفيات المشاركة مباشرة من خلال التطبيق، مع إمكانية متابعة مواعيدك والتذكير بها.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                            هل يدعم التطبيق الأجهزة المحمولة؟
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="panelsStayOpen-collapseThree">
                                        <div class="accordion-body">
                                            بالطبع، تطبيق أين علاجي متوافق مع جميع أجهزة الهواتف الذكية والأجهزة اللوحية، ويوفر تجربة سهلة وسلسة للمستخدمين.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                                            هل يقدم التطبيق دعمًا مستمرًا؟
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="panelsStayOpen-collapseFour">
                                        <div class="accordion-body">
                                            نعم، نحن نقدم دعمًا فنيًا مستمرًا لضمان عمل التطبيق بشكل ممتاز، ونرحب بأي استفسارات أو اقتراحات من المستخدمين.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======= تواصل معنا - تسجيل صيدلية =======-->
        <section class="section contact__v2" id="sub">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-6 col-lg-7 mx-auto text-center">
                        <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">تسجيل صيدلية</span>
                        <h2 class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">اشترك في تطبيق أين علاجي</h2>
                        <p data-aos="fade-up" data-aos-delay="100">إذا كنت تملك صيدلية وترغب في التسجيل والاشتراك في تطبيقنا، يرجى تعبئة النموذج أدناه بدقة.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-column gap-4" data-aos="fade-up" data-aos-delay="0">

                            <div>
                                <h5><i class="bi bi-person"></i> اسم صاحب الصيدلية</h5>
                                <p>يرجى إدخال اسم صاحب الصيدلية كامل رباعي</p>
                            </div>
                            <div>
                                <h5><i class="bi bi-mailbox"></i> البريد الاكتروني  لصاحب الصيدلية</h5>
                                <p>يرجى إدخال البريد الاكتروني  فعال لصاحب الصيدلي  </p>
                            </div>
                            <div>
                                <h5><i class="bi bi-phone"></i>   رقم التواصل لصاحب الصيدلية</h5>
                                <p>يرجى إدخال  رقم التواصل  فعال لصاحب الصيدلي  </p>
                            </div>
                            <div>
                                <h5><i class="bi bi-shop"></i> اسم الصيدلية</h5>
                                <p>يرجى إدخال الاسم الرسمي للصيدلية الخاصة بك كما هو مسجل.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-image"></i> صورة الصيدلية</h5>
                                <p>قم برفع صورة واضحة للصيدلية، يمكن أن تكون صورة للواجهة أو داخل الصيدلية.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-file-earmark-text"></i> رقم الرخصة</h5>
                                <p>أدخل رقم الترخيص الصادر من الجهات المختصة للصيدلية.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-file-earmark"></i> ملف الرخصة</h5>
                                <p>قم برفع نسخة من ملف الرخصة سواء كان PDF أو صورة واضحة.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-calendar-event"></i> تاريخ انتهاء الرخصة</h5>
                                <p>حدد تاريخ انتهاء صلاحية الرخصة لضمان تحديث بياناتك بشكل مستمر.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-telephone"></i> رقم هاتف الصيدلية</h5>
                                <p>يرجى إدخال رقم هاتف الصيدلية لتسهيل التواصل معكم.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-envelope"></i> البريد الإلكتروني للصيدلية</h5>
                                <p>أدخل البريد الإلكتروني الرسمي للصيدلية لاستقبال الإشعارات.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-building"></i> حالة الصيدلية</h5>
                                <p>اختر إذا كانت الصيدلية مفتوحة حالياً أو مغلقة.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-clock"></i> ساعات العمل</h5>
                                <p>حدد ساعات العمل الرسمية للصيدلية (مثلاً: من 9 صباحًا حتى 9 مساءً).</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-geo-alt"></i> موقع الصيدلية</h5>
                                <p>حدد موقع الصيدلية على الخريطة لتسهيل العثور عليها.</p>
                            </div>

                            <div>
                                <h5><i class="bi bi-pencil-square"></i> وصف الصيدلية</h5>
                                <p>اكتب وصفًا مختصرًا للصيدلية يشمل الخدمات أو المميزات التي تقدمها.</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-wrapper" data-aos="fade-up" data-aos-delay="300">
                            <form id="pharmacyRegistrationForm" enctype="multipart/form-data">
                                 @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">اسم صاحب  الصيدلية</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الاكتروني لصاحب الصيدلية</label>
                                    <input type="text" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">رقم التوصل  لصاحب الصيدلية</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name_pharmacy" class="form-label">اسم الصيدلية</label>
                                    <input type="text" class="form-control" id="name_pharmacy" name="name_pharmacy" required>
                                </div>

                                <div class="mb-3">
                                    <label for="image_pharmacy" class="form-label">صورة الصيدلية</label>
                                    <input type="file" class="form-control" id="image_pharmacy" name="image_pharmacy" accept="image/*" required>
                                </div>

                                <div class="mb-3">
                                    <label for="license_number" class="form-label">رقم الرخصة</label>
                                    <input type="text" class="form-control" id="license_number" name="license_number" required>
                                </div>

                                <div class="mb-3">
                                    <label for="license_file_path" class="form-label">ملف الرخصة (PDF أو صورة)</label>
                                    <input type="file" class="form-control" id="license_file_path" name="license_file_path" accept=".pdf,image/*" required>
                                </div>

                                <div class="mb-3">
                                    <label for="license_expiry_date" class="form-label">تاريخ انتهاء الرخصة</label>
                                    <input type="date" class="form-control" id="license_expiry_date" name="license_expiry_date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone_number_pharmacy" class="form-label">رقم هاتف الصيدلية</label>
                                    <input type="tel" class="form-control" id="phone_number_pharmacy" name="phone_number_pharmacy" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email_pharmacy" class="form-label">البريد الإلكتروني للصيدلية</label>
                                    <input type="email" class="form-control" id="email_pharmacy" name="email_pharmacy" required>
                                </div>

                                <div class="mb-3">
                                    <label for="status_exist" class="form-label">حالة الصيدلية</label>
                                    <select class="form-select" id="status_exist" name="status_exist" required>
                                        <option value="open">مفتوحة</option>
                                        <option value="closed">مغلقة</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="working_hours" class="form-label">ساعات العمل</label>
                                    <input type="text" class="form-control" id="working_hours" name="working_hours" placeholder="مثال: 9 صباحًا - 9 مساءً" required>
                                </div>

                                <!-- خريطة تحديد الموقع -->
                                <div class="mb-3">
                                    <label for="pharmacy_location_map" class="form-label">حدد موقع الصيدلية على الخريطة</label>
                                    <div id="map" style="height: 300px; border: 1px solid #ccc;"></div>
                                    <!-- حقول مخفية لإرسال الإحداثيات -->
                                    <input type="hidden" id="latitude" name="latitude" required>
                                    <input type="hidden" id="longitude" name="longitude" required>
                                </div>


                                <div class="mb-3">
                                    <label for="description" class="form-label">وصف الصيدلية</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="اكتب وصفًا مختصرًا عن الصيدلية" required></textarea>
                                </div>

                                <button type="button" id="register-pharmacy" class="btn btn-primary fw-semibold">تسجيل الصيدلية</button>
                            </form>
                            <div class="mt-3 d-none alert alert-success" id="successMessage">تم تسجيل الصيدلية بنجاح!</div>
                            <div class="mt-3 d-none alert alert-danger" id="errorMessage">حدث خطأ أثناء التسجيل. يرجى المحاولة لاحقًا.</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- نهاية تسجيل الصيدلية -->


        <!-- ======= التذييل ======= -->
        <footer class="footer pt-5 pb-5">
            <div class="container">
                <div class="row mb-5 pb-4">
                    <div class="col-md-7">
                        <h2 class="fs-5">انضم إلى نشرتنا الإخبارية</h2>
                        <p>ابقَ على اطلاع بأحدث النصائح الطبية والعروض الخاصة – اشترك في نشرتنا الإخبارية اليوم!</p>
                    </div>
                    <div class="col-md-5">
                        <form class="d-flex gap-2">
                            <input class="form-control" type="email" placeholder="أدخل بريدك الإلكتروني" required="">
                            <button class="btn btn-primary fs-6" type="submit">اشترك</button>
                        </form>
                    </div>
                </div>
                <div class="row justify-content-between mb-5 g-xl-5">
                    <div class="col-md-4 mb-5 mb-lg-0">
                        <h3 class="mb-3">عن التطبيق</h3>
                        <p class="mb-4">استخدم أدواتنا لتطوير خطة علاجية مخصصة وتحقيق رؤيتك الصحية. بعد الانتهاء، يمكنك مشاركة نتائجك بسهولة.</p>
                    </div>
                    <div class="col-md-7">
                        <div class="row g-2">
                            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                                <h3 class="mb-3">الشركة</h3>
                                <ul class="list-unstyled">
                                    <li><a href="page-about.html">الإدارة</a></li>
                                    <li><a href="page-careers.html">الوظائف <span class="badge ms-1">نحن نوظف</span></a></li>
                                    <li><a href="page-case-studies.html">دراسات الحالة</a></li>
                                    <li><a href="page-terms-conditions.html">الشروط والأحكام</a></li>
                                    <li><a href="page-privacy-policy.html">سياسة الخصوصية</a></li>
                                    <li><a href="page-404.html">صفحة 404</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                                <h3 class="mb-3">الحسابات</h3>
                                <ul class="list-unstyled">
                                    <li><a href="page-signup.html">تسجيل حساب</a></li>
                                    <li><a href="page-signin.html">تسجيل الدخول</a></li>
                                    <li><a href="page-forgot-password.html">نسيت كلمة المرور</a></li>
                                    <li><a href="page-coming-soon.html">قريباً</a></li>
                                    <li><a href="page-portfolio-masonry.html">معرض الأعمال</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 quick-contact">
                                <h3 class="mb-3">تواصل معنا</h3>
                                <p class="d-flex mb-3"><i class="bi bi-geo-alt-fill me-3"></i><span>123 شارع الرئيسي، شقة 4ب، سبرينغفيلد، <br> إلينوي 62701، الولايات المتحدة</span></p>
                                <a class="d-flex mb-3" href="mailto:info@mydomain.com"><i class="bi bi-envelope-fill me-3"></i><span>info@mydomain.com</span></a>
                                <a class="d-flex mb-3" href="tel://+123456789900"><i class="bi bi-telephone-fill me-3"></i><span>+1 (234) 5678 9900</span></a>
                                <a class="d-flex mb-3" href="https://freebootstrap.net"><i class="bi bi-globe me-3"></i><span>FreeBootstrap.net</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row credits pt-3">
                    <div class="col-xl-8 text-center text-xl-start mb-3 mb-xl-0">
                        <!--
                        ملاحظة:
                        =>>> يرجى الحفاظ على جميع روابط التذييل كما هي. <<<=
                        =>>> يمكنك إزالة الروابط فقط إذا اشتريت النسخة المدفوعة. <<<=
                        =>>> اشترِ النسخة المدفوعة التي تتضمن نموذج تواصل فعال باستخدام PHP/AJAX والعديد من الميزات الإضافية: https://freebootstrap.net/template/vertex-pro-bootstrap-website-template-for-portfolio/ <<<=
                        -->
                        &copy;
                        <script>document.write(new Date().getFullYear());</script> نوفا.
                        جميع الحقوق محفوظة. تم التصميم بحب <i class="bi bi-heart-fill text-danger"></i> بواسطة <a href="https://freebootstrap.net">FreeBootstrap.net</a>
                    </div>
                    <div class="col-xl-4 justify-content-start justify-content-xl-end quick-links d-flex flex-column flex-xl-row text-center text-xl-start gap-1">تم التوزيع بواسطة<a href="https://themewagon.com" target="_blank">ThemeWagon</a></div>
                </div>
            </div>
        </footer>
        <!-- نهاية التذييل -->

    </main>
</div>

<!-- ======= Back to Top =======-->
<button id="back-to-top"><i class="bi bi-arrow-up-short"></i></button>
<!-- End Back to top-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ======= Javascripts =======-->
<script src="assets/vendors/bootstrap/bootstrap.bundle.min.js"></script>
<script src="assets/vendors/gsap/gsap.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="assets/vendors/isotope/isotope.pkgd.min.js"></script>
<script src="assets/vendors/glightbox/glightbox.min.js"></script>
<script src="assets/vendors/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendors/aos/aos.js"></script>
<script src="assets/vendors/purecounter/purecounter.js"></script>
<script src="assets/js/custom.js"></script>
 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>


<script src="assets/plugins/global/plugins.bundle.js"></script>

<script src="assets/js/scripts.bundle.js"></script>

<script src="assets/js/custom/apps/pharmacy-management/location-pharmacy/list/add-pharmacy.js"></script>

</body>
</html>
