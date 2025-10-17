<template>
  <div class="container mt-4">
    <h2 class="mb-3">รายชื่อพนักงาน</h2>
    
    <div class="mb-3">
      <a class="btn btn-primary" href="/addemployee" role="button">เพิ่มพนักงาน +</a>
    </div>

    <!-- ตารางแสดงข้อมูลพนักงาน -->
    <table class="table table-bordered table-striped">
      <thead class="table-success">
        <tr>
          <th>รหัสพนักงาน</th>
          <th>ชื่อ</th>
          <th>นามสกุล</th>
          <th>ชื่อผู้ใช้</th>
          <th>รูปภาพ</th>
          <th>จัดการ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="employee in employees" :key="employee.id">
          <td>{{ employee.id }}</td>
          <td>{{ employee.firstname }}</td>
          <td>{{ employee.lastname }}</td>
          <td>{{ employee.username }}</td>
          <td class="text-center">
            <img 
              v-if="employee.image" 
              :src="`http://localhost/project-67700660_vue/api_php/uploads/${employee.image}`" 
              alt="Employee" 
              class="rounded-circle"
              style="width: 50px; height: 50px; object-fit: cover;"
            >
            <span v-else class="text-muted">-</span>
          </td>
          <!-- ปุ่มจัดการ -->
          <td class="text-center">  
            <button 
              class="btn btn-warning btn-sm me-2" 
              @click="editEmployee(employee.id)"
            >
              แก้ไข
            </button>
            <button 
              class="btn btn-danger btn-sm" 
              @click="deleteEmployee(employee.id)"
            >
              ลบ
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- แสดงเมื่อไม่มีข้อมูล -->
    <div v-if="!loading && employees.length === 0" class="alert alert-info text-center">
      ไม่มีข้อมูลพนักงาน
    </div>

    <!-- Loading -->
    <div v-if="loading" class="text-center my-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">กำลังโหลด...</span>
      </div>
      <p class="mt-2">กำลังโหลดข้อมูล...</p>
    </div>

    <!-- Error -->
    <div v-if="error" class="alert alert-danger" role="alert">
      <strong>เกิดข้อผิดพลาด!</strong> {{ error }}
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

export default {
  name: "EmployeeList",
  setup() {
    const router = useRouter();
    const employees = ref([]);
    const loading = ref(true);
    const error = ref(null);

    // ฟังก์ชันดึงข้อมูลพนักงานจาก API
    const fetchEmployees = async () => {
      try {
        loading.value = true;
        const response = await fetch("http://localhost/project-67700660_vue/api_php/show_employee.php", {
          method: "GET",
          headers: {
            "Content-Type": "application/json"
          }
        });

        if (!response.ok) {
          throw new Error("ไม่สามารถดึงข้อมูลได้");
        }

        const result = await response.json();
        
        if (result.success) {
          employees.value = result.data;
        } else {
          error.value = result.message || "ไม่สามารถดึงข้อมูลได้";
        }

      } catch (err) {
        error.value = err.message;
        console.error("Error fetching employees:", err);
      } finally {
        loading.value = false;
      }
    };

    // ฟังก์ชันแก้ไขข้อมูลพนักงาน
    const editEmployee = (id) => {
      router.push(`/editemployee/${id}`);
    };

    // ฟังก์ชันลบข้อมูลพนักงาน
    const deleteEmployee = async (id) => {
      if (!confirm("คุณต้องการลบข้อมูลพนักงานนี้ใช่หรือไม่?")) return;

      try {
        const response = await fetch("http://localhost/project-67700660_vue/api_php/api_employee.php", {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({ id: id })
        });

        const result = await response.json();

        if (result.success) {
          // ลบออกจาก employees array
          employees.value = employees.value.filter(e => e.id !== id);
          alert("ลบข้อมูลสำเร็จ");
        } else {
          alert("ไม่สามารถลบข้อมูลได้: " + result.message);
        }

      } catch (err) {
        alert("เกิดข้อผิดพลาด: " + err.message);
        console.error("Error deleting employee:", err);
      }
    };

    onMounted(() => {
      fetchEmployees();
    });

    return {
      employees,
      loading,
      error,
      editEmployee,
      deleteEmployee
    };
  }
};
</script>

<style scoped>
.table thead th {
  vertical-align: middle;
}

.table tbody td {
  vertical-align: middle;
}

.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
}
</style>