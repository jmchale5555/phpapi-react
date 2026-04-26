import NavBar from './NavBar'

export default function Layout({ children, theme, onToggleTheme }) {
  return (
    <div className="min-h-screen bg-gradient-to-b from-slate-50 via-slate-100 to-slate-200 text-slate-900 transition-colors dark:from-slate-950 dark:via-slate-900 dark:to-slate-800 dark:text-slate-100">
      <NavBar theme={theme} onToggleTheme={onToggleTheme} />
      <main className="mx-auto w-full max-w-4xl px-4 py-10">{children}</main>
    </div>
  )
}
