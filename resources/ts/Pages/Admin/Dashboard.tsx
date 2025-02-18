import AdminLayout from "@/Layouts/AdminLayout"


const Dashboard = () =>
{
    return (<AdminLayout>
        <section className='search'>
            <header>
                <h1>進行中の発注一覧</h1>
            </header>
            <div className="content"></div>
        </section>

    </AdminLayout>)
}

export default Dashboard