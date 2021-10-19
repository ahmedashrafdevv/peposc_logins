<template>
  <h2>asd</h2>
</template>

<script>
export default {
  created() {
    localStorage.setItem("token", this.$route.params.token);
    setTimeout(() => {
      window.close();
    }, 300);
  },
};
</script>