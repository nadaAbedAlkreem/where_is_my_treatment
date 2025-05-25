document.addEventListener("DOMContentLoaded", function () {
    const months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
        'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];

     const data = Array(12).fill(0);

     if (typeof userCounts === 'object' && !Array.isArray(userCounts)) {
        Object.entries(userCounts).forEach(([month, count]) => {
            const index = parseInt(month) - 1;
            if (index >= 0 && index < 12) {
                data[index] = count;
            }
        });
    } else {
        console.warn("⚠️ تنبيه: userCounts ليست كائنًا كما هو متوقع، وإنما مصفوفة. يرجى تعديل طريقة التمرير من Laravel.");
    }

    const options = {
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false },
            zoom: { enabled: false },
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        series: [{
            name: 'عدد المستخدمين',
            data: data
        }],
        xaxis: {
            categories: months,
            labels: { rotate: -45 }
        },
        yaxis: {
            labels: { formatter: val => val.toFixed(0) }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 90, 100]
            }
        },
        colors: ['#00c9a7']
    };
    const chartEl = document.querySelector("#userGrowthChart");
    if (chartEl) {
        const chart = new ApexCharts(chartEl, options);
        try {
            chart.render();
        } catch (error) {
            console.error("خطأ أثناء إنشاء المخطط:", error);
        }
    } else {
        console.error("العنصر #userGrowthChart غير موجود في الصفحة.");
    }
});
