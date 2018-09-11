<template>
  <div class="flex">
    <div
      v-for="(field, index) in fields"
      :key="index"
      class="border-40 border"
      :class="field.fieldClasses"
    >{{ field.name }}</div>
  </div>
</template>
<script>
export default {
  props: {
    fields: {
      type: Array,
      default: () => []
    }
  }
};
</script>
