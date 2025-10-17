<template>
  <div class="container mt-4 col-md-4 bg-body-secondary ">
    <h2 class="text-center mb-3">ลงทะเบียน</h2>
    <form @submit.prevent="addCustomer">
      <div class="mb-2">
        <input v-model="customer.firstname" class="form-control" placeholder="ชื่อ" required />
      </div>
      <div class="mb-2">
        <input v-model="customer.lastname" class="form-control" placeholder="นามสกุล" required />
      </div>
      <div class="mb-2">
        <input v-model="customer.phone" class="form-control" placeholder="เบอร์โทร" />
      </div>
      <div class="mb-2">
        <input v-model="customer.username" class="form-control" placeholder="ชื่อผู้ใช้" required />
      </div>
      <div class="mb-2">
        <input type="password" v-model="customer.password" class="form-control" placeholder="รหัสผ่าน" required />
      </div>
      <div class="text-center mt-4 ">
        <button type="submit" class="btn btn-primary mb-4">บันทึก</button> &nbsp;
        <button type="reset" class="btn btn-secondary mb-4" @click="resetForm">ยกเลิก</button>
      </div>
    </form>

    <div v-if="message" class="alert" :class="messageType">
      {{ message }}
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      customer: {
        firstname: "",   // ✅ เปลี่ยนจาก firstName
        lastname: "",    // ✅ เปลี่ยนจาก lastName
        phone: "",
        username: "",
        password: ""
      },
      message: "",
      messageType: "alert-info"
    };
  },
  methods: {
    async addCustomer() {
      try {
        console.log('Sending data:', this.customer); // Debug

        const res = await fetch("http://localhost/project-67700660_vue/api_php/add_employee.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(this.customer)
        });

        const data = await res.json();
        console.log('Response:', data); // Debug

        this.message = data.message;

        if (data.success) {
          this.messageType = "alert-success";
          // ✅ เคลียร์ข้อมูลใน textbox หลังบันทึกสำเร็จ
          this.customer = { 
            firstname: "", 
            lastname: "", 
            phone: "", 
            username: "", 
            password: "" 
          };
        } else {
          this.messageType = "alert-danger";
        }

      } catch (err) {
        this.message = "เกิดข้อผิดพลาด: " + err.message;
        this.messageType = "alert-danger";
        console.error('Error:', err); // Debug
      }
    },
    
    resetForm() {
      this.customer = { 
        firstname: "", 
        lastname: "", 
        phone: "", 
        username: "", 
        password: "" 
      };
      this.message = "";
    }
  }
}
</script>