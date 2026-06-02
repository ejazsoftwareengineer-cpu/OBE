// const puppeteer = require('puppeteer');
// const fs = require('fs');

// (async () => {
//     try {
//         const browser = await puppeteer.launch();
//         const page = await browser.newPage();

//         await page.setContent(`
//             <html>
//                 <head>
//                     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
//                 </head>
//                 <body>
//                     <canvas id="myChart" width="400" height="400"></canvas>
//                     <script>
//                         const ctx = document.getElementById('myChart').getContext('2d');
//                         const myChart = new Chart(ctx, {
//                             type: 'bar',
//                             data: {
//                                 labels: ['foo', 'bar'],
//                                 datasets: [{
//                                     label: 'CLO Attainment',
//                                     data: [1, 1],
//                                     backgroundColor: 'rgba(54, 162, 235, 1)',
//                                     borderColor: 'rgba(54, 162, 235, 1)',
//                                     borderWidth: 1
//                                 }]
//                             },
//                             options: {
//                                 scales: {
//                                     y: {
//                                         beginAtZero: true,
//                                         max: 100,
//                                         ticks: {
//                                             callback: function(value) {
//                                                 return value + '%';
//                                             }
//                                         },
//                                         title: {
//                                             display: true,
//                                             text: '% Attainment'
//                                         }
//                                     }
//                                 }
//                             }
//                         });
//                     </script>
//                 </body>
//             </html>
//         `);

//         await page.waitForSelector('#myChart');

//         const chartCanvas = await page.$('#myChart');
//         await chartCanvas.screenshot({ path: 'C:/xampp/htdocs/obe/storage/app/public/chart.png' });

//         await browser.close();
//     } catch (error) {
//         console.error('Error generating chart:', error);
//         process.exit(1);
//     }
// })();
const puppeteer = require('puppeteer');
const fs = require('fs');

(async () => {
    try {
        // const labels = JSON.parse(process.env.LABELS);
        // const data = JSON.parse(process.env.DATA);
        // const outputPath = process.env.OUTPUT_PATH;
        const labels = JSON.parse('["Label1", "Label2", "Label3"]');
        const data = JSON.parse('[10, 20, 30]');
        const outputPath = 'storage/app/public/clo_chart.png';

        console.log('Labels:', labels);
        console.log('Data:', data);
        console.log('Output Path:', outputPath);

        const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox', '--disable-setuid-sandbox'] });
        const page = await browser.newPage();

        await page.setContent(`
            <html>
                <head>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                </head>
                <body>
                    <canvas id="myChart" width="400" height="400"></canvas>
                    <script>
                        const ctx = document.getElementById('myChart').getContext('2d');
                        const myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ${JSON.stringify(labels)},
                                datasets: [{
                                    label: 'CLO Attainment',
                                    data: ${JSON.stringify(data)},
                                    backgroundColor: 'rgba(54, 162, 235, 1)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        ticks: {
                                            callback: function(value) {
                                                return value + '%';
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: '% Attainment'
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </body>
            </html>
        `);

        await page.waitForSelector('#myChart');

        const chartCanvas = await page.$('#myChart');
        await chartCanvas.screenshot({ path: outputPath });

        await browser.close();
        console.log('Chart image generated successfully.');
    } catch (error) {
        console.error('Error generating chart:', error);
        process.exit(1);
    }
})();