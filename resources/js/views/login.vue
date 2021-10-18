<template>
    <div>
        asd
    </div>
</template>

<script>
import Api from '../Api';
export default {
  async mounted() {
    const email = this.$route.params.email 
    Api.post('login' , {email}).then(res => {
      const token = res.data.access_token
      localStorage.setItem("token", token);
      this.$router.push({name : 'user'})
    }).catch(err => {
      console.log(err)
    })
    const rawResponse = await fetch(`/api/login`, {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify(),
    });
    const content = await rawResponse.json();
    console.log(content)
    localStorage.setItem("token", content.access_token);
    // this.$router.replcae("user");
    // console.log(content.access_token);
  },
};
</script>