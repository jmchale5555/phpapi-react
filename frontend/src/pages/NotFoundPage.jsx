import { Link } from 'react-router-dom'

export default function NotFoundPage() {
  return (
    <section className="rounded-xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-200 transition-colors dark:bg-slate-900 dark:ring-slate-700">
      <h1 className="mb-2 text-2xl font-bold text-slate-900 dark:text-slate-100">Page not found</h1>
      <p className="mb-4 text-slate-600 dark:text-slate-300">The route you requested does not exist in the SPA.</p>
      <Link className="font-semibold text-sky-700 hover:underline dark:text-sky-300" to="/">
        Return home
      </Link>
    </section>
  )
}
