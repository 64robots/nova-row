export default {
  data() {
    return {
      values: []
    };
  },

  created() {
    if (!this.field.value) return;

    const values = this.field.value || [];

    values.forEach(value => this.addItemToRow(value));
  },

  methods: {
    addItemToRow(obj) {
      Object.assign(obj, {
        row_id: Math.random()
          .toString(36)
          .substr(2, 9)
      });
      this.$set(this.values, this.values.length, obj);
    }
  }
};
