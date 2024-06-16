<template>
  <div class="container-fluid mt-5">
    <div class="justify-content-center align-items-center">
        
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Login</h2>
                    <form method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="usernameEmail"
                                placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control mb-2" id="password" name="password"
                                placeholder="Enter password">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <p>Dont have an account yet? <a href="/signup">Sign up!</a> </p>
                </div>
            </div>
        </div>
    </div>
    

</template>

<script>

export default {
  data() {
    return {
      username: '',
      password: ''
    }
  }, 
  methods: {
    onSubmit() {
      // Handle form submission
      console.log('Form submitted with:', this.username, this.password)
    }
  }
}
</script>

<style scoped>

</style>
