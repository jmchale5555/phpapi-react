import { Link, NavLink } from 'react-router-dom'
import { Moon, Sun } from 'lucide-react'

const active = 'text-sky-700 dark:text-sky-300 underline underline-offset-4'

export default function NavBar({ theme, onToggleTheme }) {
  return (
    <header className="border-b border-slate-200 bg-white/80 backdrop-blur transition-colors dark:border-slate-700 dark:bg-slate-900/80">
      <div className="mx-auto flex w-full max-w-4xl items-center justify-between px-4 py-4">
        <Link to="/" className="text-lg font-bold text-slate-900 dark:text-slate-100">
          PHP SPA Boilerplate
        </Link>
        <nav className="flex items-center gap-4 text-sm font-medium text-slate-700 dark:text-slate-300">
          <NavLink to="/" end className={({ isActive }) => (isActive ? active : '')}>
            Home
          </NavLink>
          <NavLink to="/login" className={({ isActive }) => (isActive ? active : '')}>
            Login
          </NavLink>
          <NavLink to="/signup" className={({ isActive }) => (isActive ? active : '')}>
            Sign up
          </NavLink>
          <button
            type="button"
            onClick={onToggleTheme}
            className="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white p-2 text-slate-700 transition-colors hover:bg-slate-100 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
            aria-label={theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'}
            title={theme === 'dark' ? 'Light mode' : 'Dark mode'}
          >
            {theme === 'dark' ? <Sun size={18} /> : <Moon size={18} />}
          </button>
        </nav>
      </div>
    </header>
  )
}
