const puppeteer = require('puppeteer');

// run node  public/js/puppet.js

(async () => {
  const browser = await puppeteer.launch({headless: false});
  const page = await browser.newPage();
  // await page.goto('https://example.com');
  // await page.goto('https://twitter.com/home?lang=ja');
  // await page.goto('https://www.google.com/')
  await page.goto('https://tinder.com/app/recs');
  // await page.screenshot({path: 'example.png'});

  // await browser.close();
})();