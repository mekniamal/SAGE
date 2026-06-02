import puppeteer from 'puppeteer';
import { fileURLToPath } from 'url';
import path from 'path';
import fs from 'fs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const htmlPath = path.join(__dirname, 'Diagrammes-UML-Ecommerce.html');
const pdfPath = path.join(__dirname, 'Diagrammes-UML-Ecommerce.pdf');

if (!fs.existsSync(htmlPath)) {
    console.error('HTML introuvable:', htmlPath);
    process.exit(1);
}

const browser = await puppeteer.launch({ headless: true });
const page = await browser.newPage();
await page.goto('file:///' + htmlPath.replace(/\\/g, '/'), {
    waitUntil: 'networkidle0',
    timeout: 120000,
});

await page.waitForFunction(
    () => {
        const blocks = document.querySelectorAll('.mermaid');
        if (blocks.length === 0) return false;
        return [...blocks].every((el) => el.querySelector('svg'));
    },
    { timeout: 90000 }
);

await page.pdf({
    path: pdfPath,
    format: 'A4',
    printBackground: true,
    margin: { top: '15mm', right: '12mm', bottom: '15mm', left: '12mm' },
});

await browser.close();
console.log('PDF créé:', pdfPath);
