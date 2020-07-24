Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-excel-helper',
      path: '/nova-excel-helper',
      component: require('./components/Tool'),
    },
  ])
})
