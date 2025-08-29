<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">รายการสินค้า</h2>
    <div class="row">
      <div class="col-md-4" v-for="product in products" :key="product.id">
        <div class="card shadow-sm mb-4">
          <img :src="product.image" class="card-img-top" :alt="product.name">
          <div class="card-body text-center">
            <h5 class="card-title">{{ product.name }}</h5>
            <p class="card-text">{{ product.price }} บาท</p>
            <button class="btn btn-primary">รายละเอียด</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>









<script>
export default {
  name: "ShowProduct",
  data() {
    return {
      products: [
        { id: 1, name: "ผ้าปูที่นอน", price: 1200, image: "https://picsum.photos/400/200?4" },
        { id: 2, name: "หมอนข้าง", price: 800, image: "https://picsum.photos/400/200?5" },
        { id: 3, name: "ผ้าห่ม", price: 550, image: "https://picsum.photos/400/200?6" },
        { id: 4, name: "ตุ๊กตา", price: 499, image: "https://picsum.photos/400/200?7" },
        { id: 5, name: "หมอนรองคอ", price: 399, image: "https://picsum.photos/400/200?8" },
        { id: 6, name: "ชุดนอน", price: 199, image: "https://picsum.photos/400/200?9" },
      ]
    }
  }
}
</script>