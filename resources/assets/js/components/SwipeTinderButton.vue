<template>
  <div class="text-center">
    <button class="" @click="swipe()">
      swipe
    </button>
  </div>
</template>

<script>
import * as api from '../services/api'
export default {
  props: {
    userId: {required: true, type: Number},
  },
  data (){
    return {
    }
  },
  created () {
  },

  methods: {
    async swipe () {
      try {
          await api.postSwipe({'user_id': this.userId})

          alert('swipe完了しました')
      } catch (error) {
          console.log(error)
      }
    },
  }
}

</script>
<style lang="scss" scoped>

</style>
