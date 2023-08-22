import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AreaListComponent } from './area-list.component';

describe('AreaListComponent', () => {
  let component: AreaListComponent;
  let fixture: ComponentFixture<AreaListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [AreaListComponent]
    });
    fixture = TestBed.createComponent(AreaListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
