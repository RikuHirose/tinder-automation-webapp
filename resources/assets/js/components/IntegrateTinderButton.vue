<template>
  <div class="text-center">
    <button class="" @click="integrate()">
      integrate
    </button>
  </div>
</template>

<script>
import puppeteer from 'puppeteer'  // eslint-disable-line
export default {
  props: {

  },
  data (){
    return {
    }
  },
  created () {
  },

  methods: {
    async integrate () {
      const browser = await puppeteer.launch();
      const page = await browser.newPage();
      await page.goto('https://example.com');
      // await page.screenshot({path: 'example.png'});

      await browser.close();
    },
  }
}

</script>
<style lang="scss" scoped>

</style>
