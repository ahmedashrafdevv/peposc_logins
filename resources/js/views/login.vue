<template></template>

<script>
import { login } from "../Api";
export default {
  async mounted() {
    login(this.$route.params.email);
  },
};
</script>