<template>
<table id="bootstrap-table2" class="table">
            <thead>
                    <tr>
                            <th data-field="logo">Logo</th>
                            <th data-field="name" data-sortable="true">Coupon Name</th>
                            <th data-field="total" data-sortable="true">Created</th>
                            <th data-field="coup-redeemed" data-sortable="true">Redeemed</th>
                            <th data-field="coup-active" data-sortable="true">Active</th>
                            <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Actions</th>
                    </tr>
            </thead>
</table>
</template>

<script>
    export default {
 name: 'temp-list',
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
