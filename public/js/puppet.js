const puppeteer = require('puppeteer');

// run node  public/js/puppet.js

(async () => {
  const browser = await puppeteer.launch({headless: false});
  const page = await browser.newPage();

  // loginする
  const cdpRequestDataRaw = await setupLoggingOfAllNetworkData(page)
  await page.goto('https://tinder.com/');
  // let data = JSON.stringify(cdpRequestDataRaw, null, 2)

  // https://tinder.com/app/recs に遷移を待つ
  // await page.waitForRequest(request => {
  //   return  request.url().includes('tinder.com/app/recs') && request.method() === 'GET'
  // })
  // await Promise.all([
  // ])
  await page.waitFor('.recsPage', {timeout: 120000})

  // https://tinder.com/app/recs にてheaderからauth_tokenを取得する
  let headers = []
  // let headers = Object.values(Object.values(cdpRequestDataRaw)[0])[0].request.headers
  // let headers = Object.values(Object.values(cdpRequestDataRaw)[1])[0].request.headers
  // console.log(Object.values(Object.values(cdpRequestDataRaw)[80])[0].request)

  for (var i = 0; i < Object.values(cdpRequestDataRaw).length; i++) {
    let data = Object.values(Object.values(cdpRequestDataRaw)[i])[0]
    // FIXME もっとなんかあるだろ!
    // if (data.request.url === 'https://api.gotinder.com/v2/meta?locale=ja') {
    if (data.type === 'Fetch') {
      console.log(data.request)
    }
    // console.log(i)
    // console.log(data)
    // console.log(data.request.headers)
  }


  // await browser.close();

  // https://stackoverflow.com/questions/47078655/missing-request-headers-in-puppeteer/62232903#62232903
  async function setupLoggingOfAllNetworkData(page) {
      const cdpSession = await page.target().createCDPSession()
      await cdpSession.send('Network.enable')
      const cdpRequestDataRaw = {}
      const addCDPRequestDataListener = (eventName) => {
          cdpSession.on(eventName, request => {
              cdpRequestDataRaw[request.requestId] = cdpRequestDataRaw[request.requestId] || {}
              Object.assign(cdpRequestDataRaw[request.requestId], { [eventName]: request })
          })
      }
      addCDPRequestDataListener('Network.requestWillBeSent')
      // addCDPRequestDataListener('Network.requestWillBeSentExtraInfo')
      // addCDPRequestDataListener('Network.responseReceived')
      // addCDPRequestDataListener('Network.responseReceivedExtraInfo')
      return cdpRequestDataRaw
  }
})();