import Purchases from '@/components/purchases/index.vue'
import Orders from '@/components/orders/index.vue'
import Meals from '@/components/meals/index.vue'
import Addons from '@/components/addons/index.vue'
import Payment from '@/components/payment/index.vue'
import Dashboard from '@/components/dashboard/index.vue'
import Users from '@/components/user/index.vue'
import ScheduledDish from '@/components/scheduledDish/index.vue'

export default [{

        path: '/',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            authOnly: true,
            title: 'Skills - MyApp'
        }

    },
    {
        path: '/purchases',
        name: 'purchases',
        component: Purchases,
        meta: { authOnly: true }
    },
    {
        path: '/orders',
        name: 'orders',
        component: Orders,
        meta: { authOnly: true }
    },
    {
        path: '/dish',
        name: 'meals',
        component: Meals,
        meta: { authOnly: true }

    },
    {
        path: '/scheduledDish',
        name: 'scheduledDish',
        component: ScheduledDish,
        meta: { authOnly: true }
    },
    {
        path: '/addons',
        name: 'addons',
        component: Addons,
        meta: { authOnly: true }
    },
    {
        path: '/payments',
        name: 'payment',
        component: Payment,
        meta: { authOnly: true }

    },
    {
        path: '/user',
        name: 'user',
        component: Users,
        meta: { authOnly: true }

    }

]

