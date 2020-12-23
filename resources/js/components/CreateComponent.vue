<template>
  <form>
    <label>Type</label>
    <select name="type" v-on:change="get_form_fields">
      <option disabled=true selected=true>Choose</option>
      <option v-for="(type,name) in types" :value=type>{{ name }}</option>
    </select>
  </form>
</template>

<script>
  export default {
    props: ['types'],
    methods: {
      /**
       * Get the form fields according to
       * the selected type
       *
       * @return void
       */
      get_form_fields(event) {

        // send the request
        this.$http.post('/texts/' event.target.value , formData).then(
          // success handler
          response => {
            this.sort = response.body.sort
            this.f_texts = response.body.texts
            this.jlpt_tag_id = response.body.jlpt_tag_id
          },
          // error handler
          response => {
            console.log('error')
          }
        )
      }
    }
  }
</script>