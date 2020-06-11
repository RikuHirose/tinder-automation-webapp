<template>
  <div class="text-center">
    <button class="" @click="integrate()">
      integrate
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
    async integrate () {
      try {
          await api.postIntegrate({'user_id': this.userId})

          alert('tinderとの連携が完了しました')
      } catch (error) {
          console.log(error)
      }
    },
  }
}

</script>
<style lang="scss" scoped>

</style>
