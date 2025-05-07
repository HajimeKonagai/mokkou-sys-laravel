import { Link, usePage } from "@inertiajs/react";

// import MenuContainer from 'blu/Laravel/Layout/ContextMenusTop'
// import MenuContainer from 'blu/Laravel/Layout/ContextMenusSide'
// import MenuContainer from 'blu/Laravel/Layout/DropdownMenusTop'
// import MenuContainer from 'blu/Laravel/Layout/DropdownMenusSide'
// import MenuContainer from 'blu/Laravel/Layout/DropdownContextMenuTop'
// import MenuContainer from 'blu/Laravel/Layout/DropdownContextMenuSide'
import MenuContainer from 'blu/Laravel/Layout/FlatMenus'
import DropdownContextMenuSide from 'blu/Laravel/Layout/DropdownContextMenuSide'

// import BaseLayout from "blu/Laravel/Layout/TopMenuLayout"
import BaseLayout from "blu/Laravel/Layout/SideMenuLayout"


import {
    project_menu,
    master_menu,
    csv_menu
} from "./admin-menus"

import { hasContext } from 'blu/Laravel/Layout/ContextMenusTop'
import { ProjectButton } from "@/Components/Admin/ProjectSection";

declare var route

const AdminLayout = ({
    title,
    children,
    className='',
}) =>
{
    const { props } = usePage()
    const { project } = props


    return (<BaseLayout
        auth={props.auth}
        title={title}
        home={<>
                <div className="">
                    <ProjectButton />
                </div>
            </>}
        menus={<>
            <MenuContainer
                menus={project_menu}
                width={190}
            />
            <MenuContainer
                menus={master_menu}
                width={190}
            />
            <DropdownContextMenuSide
                menus={csv_menu}
                width={190}
            />
        </>}
        className={className}
        width={200}
    >
        {children}
    </BaseLayout>)
}
export default AdminLayout
