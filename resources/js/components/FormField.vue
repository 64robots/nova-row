<template>
  <default-field :field="field">
    <template slot="field">
      <div class="row-container">
        <div
          v-for="(field, index) in fields"
          :key="index"
          class="border-40 border"
          :class="field.fieldClasses"
        >{{ field.name }}</div>
      </div>
      <div
        v-for="row in values"
        :key="row.row_id"
        class="row-container border-40 border relative"
      >
        <component
          class="remove-bottom-border w-full"
          :key="`${row.row_id}${index}`"
          v-for="(field, index) in fields"
          v-model="row[field.attribute]"
          :is="`form-${field.component}`"
          :resource-name="resourceName"
          :resource-id="resourceId"
          :field="field"
        />
        <span
          class="flex items-center justify-center bg-danger text-white p-2 m-2 w-6 h-6 rounded-full cursor-pointer font-bold"
          @click="deleteRow(row.row_id)"
        >x</span>
      </div>
      <div class="flex justify-end">
        <a
          class="btn btn-primary p-3 rounded cursor-pointer mt-3"
          @click="addRow"
        >Add Row</a>
      </div>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      values: [],
      fields: this.field.fields
    };
  },

  watch: {
    values: {
      deep: true,
      handler(values) {
        this.value = values.map(value => {
          const copy = Object.assign({}, value);
          delete copy.row_id;
          return copy;
        });
        this.$emit('input', this.value);
        console.log(this.value);
      }
    }
  },

  methods: {
    addRow() {
      const obj = this.fields.reduce(function(result, field) {
        result[field.attribute] = '';
        return result;
      }, {});

      Object.assign(obj, {
        row_id: Math.random()
          .toString(36)
          .substr(2, 9)
      });
      this.$set(this.values, this.values.length, obj);
    },

    deleteRow(id) {
      const index = this.values.findIndex(row => row.row_id === id);
      this.values.splice(index, 1);
    },

    /*
    * Set the initial, internal value for the field.
    */
    setInitialValue() {
      this.value = this.field.value || [];
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || []);
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = value;
    }
  }
};
</script>
<style scoped>
.row-container {
  display: flex;
}
</style>
