import { Link, usePage } from "@inertiajs/react";

import 'blu/sass/blu.scss';

// import MenuContainer from 'blu/Laravel/Layout/ContextMenusTop'
// import MenuContainer from 'blu/Laravel/Layout/ContextMenusSide'
// import MenuContainer from 'blu/Laravel/Layout/DropdownMenusTop'
// import MenuContainer from 'blu/Laravel/Layout/DropdownMenusSide'
import MenuContainer from 'blu/Laravel/Layout/DropdownContextMenuTop'
// import MenuContainer from 'blu/Laravel/Layout/DropdownContextMenuSide'
// import MenuContainer from 'blu/Laravel/Layout/FlatMenus'

import BaseLayout from "blu/Laravel/Layout/TopMenuLayout"
// import BaseLayout from "blu/Laravel/Layout/SideMenuLayout"
import menus from "./admin-menus"

import { hasContext } from 'blu/Laravel/Layout/ContextMenusTop'

declare var route

const AdminLayout = ({
    title,
    children,
    className='',
}) =>
{
    const { props } = usePage()

    return (<BaseLayout
        auth={props.auth}
        title={title}
        home={<>
                <div>
                    <Link href={route('admin.dashboard')}>Dashboard</Link>
                </div>
            </>}
        menus={<MenuContainer
            menus={menus}
        />}
        className={className}
        width={300}
    >
        {children}
    </BaseLayout>)
}
export default AdminLayout
