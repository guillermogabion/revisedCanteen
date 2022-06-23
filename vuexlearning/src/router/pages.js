import Grades from '@/components/grades/index.vue'
import Instructors from '@/components/instructors/index.vue'
import Students from '@/components/students/index.vue'
import Subject from '@/components/subjects/index.vue'
import Announcements from '@/components/announcements/index.vue'
import Dashboard from '@/components/dashboard/index.vue'

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
        path: '/grades',
        name: 'grades',
        component: Grades,
        meta: { authOnly: true }
    },
    {
        path: '/instructors',
        name: 'instructors',
        component: Instructors,
        meta: { authOnly: true }
    },
    {
        path: '/students',
        name: 'students',
        component: Students,
        meta: { authOnly: true }

    },
    {
        path: '/subjects',
        name: 'subject',
        component: Subject,
        meta: { authOnly: true }
    },
    {
        path: '/announcements',
        name: 'announcements',
        component: Announcements,
        meta: { authOnly: true }

    }
]

