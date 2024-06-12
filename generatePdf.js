const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto('http://localhost/project/admin/revenue.php', { waitUntil: 'networkidle2' });

    // Thử đợi một yếu tố khác hoặc thêm thời gian chờ
    try {
        await page.waitForSelector('#pie_chart', { timeout: 60000 }); // Thử đợi một yếu tố khác và tăng thời gian chờ
    } catch (e) {
        console.error('Failed to find the pie chart:', e);
        await browser.close();
        return;
    }

    // Tăng độ trễ để chờ biểu đồ render (nếu cần)
    await page.waitForSelector('#pie_chart', { timeout: 60000 }); // Tăng thời gian chờ lên 60 giây


    // Tạo PDF
    await page.pdf({ path: 'C:/Users/ADMIN/Desktop/revenue2.pdf', format: 'A4' });

    await browser.close();
})();
