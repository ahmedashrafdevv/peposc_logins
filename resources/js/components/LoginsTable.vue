<template>
    <table>
      <tr>
        <th>Email</th>
        <th>Name</th>
        <th>Provider</th>
        <th>Date</th>
        <th v-if="actions">actions</th>
      </tr>
      <tr v-for="login in logins" :key="login.email">
        <td>{{ login.email }}</td>
        <td>{{ login.name }}</td>
        <td>{{ login.provider }}</td>
        <td>{{ login.created_at }}</td>
        <td v-if="actions" class="flex justify-center">
          <div class="buttons">
            <a href="#" @click.prevent="decline(login)" class="button danger">
              decline
            </a>
            <a href="#" @click.prevent="approve(login)" class="button success">
              approve
            </a>
          </div>
        </td>
      </tr>
    </table>
</template>

<script>
    export default {
       props:{
           logins:{
               type:Array
           },
           actions:{
             type:Boolean,
             default:true
           }
       }
    }
</script>
